const { chromium } = require('playwright');
const path = require('node:path');

const baseUrl = 'http://127.0.0.1:8000';
const shotsDir = path.resolve('docs/user-manual/screenshots');

const users = [
  {
    key: 'superadmin',
    email: 'abirhossainofficial784@gmail.com',
    password: 'password123',
    pages: [
      ['dashboard', '/'],
      ['add-user', '/register'],
      ['users-list', '/usersList'],
      ['add-order', '/Order'],
      ['order-list', '/OrderShow'],
      ['completed-orders', '/OrderCompletedShow'],
      ['order-fields', '/OrderFields'],
      ['profile', '/profile']
    ]
  },
  {
    key: 'admin',
    email: 'abirwebcodee@gmail.com',
    password: 'password123',
    pages: [
      ['dashboard', '/'],
      ['add-user', '/register'],
      ['users-list', '/usersList'],
      ['add-order', '/Order'],
      ['order-list', '/OrderShow'],
      ['completed-orders', '/OrderCompletedShow'],
      ['profile', '/profile']
    ]
  },
  {
    key: 'client',
    email: 'shukhi.photos@gmail.com',
    password: 'password123',
    pages: [
      ['dashboard', '/'],
      ['add-order', '/Order'],
      ['order-list', '/OrderShow'],
      ['completed-orders', '/OrderCompletedShow'],
      ['profile', '/profile']
    ]
  }
];

async function login(page, email, password) {
  await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle' });
  await page.fill('input[name="email"]', email);
  await page.fill('input[name="password"]', password);
  await page.click('button[type="submit"]');
  await page.waitForLoadState('networkidle');
  await page.waitForTimeout(1500);

  if (page.url().includes('/login')) {
    const errorText = await page.locator('.text-danger').allTextContents();
    throw new Error(`Login failed for ${email}. URL stayed on /login. Errors: ${errorText.join(' | ')}`);
  }
}

async function logout(page) {
  const profileButton = page.locator('button[data-bs-toggle="dropdown"]').first();
  if (await profileButton.count()) {
    await profileButton.click();
    const logoutLink = page.locator('a[href$="/logout"]').first();
    if (await logoutLink.count()) {
      await Promise.all([
        page.waitForURL((url) => url.toString().includes('/login'), { timeout: 20000 }),
        logoutLink.click()
      ]);
    }
  }
}

(async () => {
  const browser = await chromium.launch({ headless: true });

  try {
    for (const user of users) {
      const context = await browser.newContext({ viewport: { width: 1600, height: 900 } });
      const page = await context.newPage();

      await login(page, user.email, user.password);

      for (const [name, route] of user.pages) {
        await page.goto(`${baseUrl}${route}`, { waitUntil: 'networkidle' });
        await page.waitForTimeout(700);
        await page.screenshot({
          path: path.join(shotsDir, `${user.key}-${name}.png`),
          fullPage: true
        });

        if (name === 'order-list') {
          const detailsLink = page.locator('a[href*="/OrderView/"]').first();
          if (await detailsLink.count()) {
            await detailsLink.click();
            await page.waitForLoadState('networkidle');
            await page.waitForTimeout(700);
            await page.screenshot({
              path: path.join(shotsDir, `${user.key}-order-details.png`),
              fullPage: true
            });
          }
        }
      }

      await logout(page);
      await context.close();
    }

    const anonContext = await browser.newContext({ viewport: { width: 1600, height: 900 } });
    const anonPage = await anonContext.newPage();
    const guestPages = [
      ['guest-login', '/login'],
      ['guest-forgot-password', '/forgot-password']
    ];

    for (const [name, route] of guestPages) {
      await anonPage.goto(`${baseUrl}${route}`, { waitUntil: 'networkidle' });
      await anonPage.waitForTimeout(700);
      await anonPage.screenshot({
        path: path.join(shotsDir, `${name}.png`),
        fullPage: true
      });
    }

    await anonContext.close();
    console.log('Screenshots captured successfully.');
  } finally {
    await browser.close();
  }
})();
