<x-app-layout>
    <x-slot name="header">Recent Orders</x-slot>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive order-table-responsive">
                <table class="table border-primary-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check style-check d-flex align-items-center">
                                    <label class="form-check-label">S.L</label>
                                </div>
                            </th>
                            <th scope="col">Name</th>
                            <th scope="col">Folder Name</th>
                            <th scope="col">Ordered By</th>
                            <th scope="col">Total Files</th>
                            <th scope="col">Order Time</th>
                            <th scope="col">Remaining Time</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order_list as $key=>$order )
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    <label class="form-check-label">{{$key+1}}</label>
                                </div>
                            </td>
                            <td>{{$order->name}}</td>
                            <td>{{$order->folder_name}}</td>
                            <td>{{$order->order_by->name}}</td>
                            <td>{{$order->total_file}}</td>
                            <td>
                                {{Carbon\Carbon::parse($order->created_at)->timezone(config('app.timezone'))->format('d-M-y')}} <br>
                                {{Carbon\Carbon::parse($order->created_at)->timezone(config('app.timezone'))->format('h:i A')}}
                            </td>
                            <td data-deadline-ts="{{ \Carbon\Carbon::parse($order->deadline)->timezone(config('app.timezone'))->timestamp * 1000 }}"></td>
                            <td>
                                {{Carbon\Carbon::parse($order->deadline)->timezone(config('app.timezone'))->format('d-M-y')}} <br>
                                {{Carbon\Carbon::parse($order->deadline)->timezone(config('app.timezone'))->format('h:i A')}}
                            </td>
                            <td>
                                @php
                                    $statusText = match ((int) $order->status) {
                                        0 => 'Pending',
                                        1 => 'Working',
                                        2 => 'QC1',
                                        3 => 'QC2',
                                        4 => 'Done',
                                        5 => 'Completed',
                                        default => 'Unknown',
                                    };
                                @endphp

                                @if (Auth::user()->role == 0 || Auth::user()->role == 1)
                                    <select class="form-select form-select-sm order-status-select" style="min-width: 140px;" data-order-id="{{ $order->id }}" data-current-status="{{ (int) $order->status }}" onchange="changeOrderStatus(this)">
                                        <option value="0" {{ (int) $order->status === 0 ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ (int) $order->status === 1 ? 'selected' : '' }}>Working</option>
                                        <option value="2" {{ (int) $order->status === 2 ? 'selected' : '' }}>QC1</option>
                                        <option value="3" {{ (int) $order->status === 3 ? 'selected' : '' }}>QC2</option>
                                        <option value="4" {{ (int) $order->status === 4 ? 'selected' : '' }}>Done</option>
                                        <option value="5" {{ (int) $order->status === 5 ? 'selected' : '' }}>Completed</option>
                                    </select>
                                @else
                                    <span class="badge bg-neutral-200 text-dark">{{ $statusText }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    <a href="{{route('order.view',$order->id)}}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                    </a>
                                @if (Auth::user()->role !=2)
                                   <button type="button" onclick="Deletion('{{$order->id}}')" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                   </button>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">No Orders to show</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-3 mt-3">
        {{ $order_list->links() }}
    </div>

    <x-slot name="script">
        <style>
            .order-table-responsive {
                overflow-x: auto;
                overflow-y: hidden;
                position: relative;
            }
        </style>

        <script>
        const orderStatusUrlTemplate = @json(route('order.status', ['id' => '__ORDER_ID__', 'status' => '__STATUS__']));

        function changeOrderStatus(selectEl) {
                const orderId = selectEl.dataset.orderId;
                const previousStatus = selectEl.dataset.currentStatus;
                const status = selectEl.value;
                const url = orderStatusUrlTemplate
                    .replace('__ORDER_ID__', orderId)
                    .replace('__STATUS__', status);

                selectEl.disabled = true;

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Failed to update status');
                        }

                        return response.json();
                    })
                    .then(() => {
                        selectEl.dataset.currentStatus = status;
                    })
                    .catch(() => {
                        selectEl.value = previousStatus;
                        Swal.fire('Error', 'Could not update order status.', 'error');
                    })
                    .finally(() => {
                        selectEl.disabled = false;
                    });
            }

        function startCountdownForAllOrders() {
                const timerCells = document.querySelectorAll('[data-deadline-ts]');

                timerCells.forEach((cell) => {
                    const deadline = Number(cell.getAttribute('data-deadline-ts'));

                    if (!Number.isFinite(deadline) || deadline <= 0) {
                        cell.textContent = '--';
                        return;
                    }

                    function updateCountdown() {
                        const now = Date.now();
                        const remainingTime = deadline - now;

                        let displayText, backgroundColor, textColor;

                        if (remainingTime <= 0) {
                            // Time has passed the deadline, show the elapsed time
                            const elapsedTime = Math.abs(remainingTime);
                            const hours = Math.floor(elapsedTime / (1000 * 60 * 60));
                            const minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

                            displayText = `-${hours} H : ${minutes} M : ${seconds} S`;
                            backgroundColor = 'red'; // Light red background for passed deadline
                            textColor = 'black';

                        } else {
                            // Time remaining until the deadline
                            const hours = Math.floor(remainingTime / (1000 * 60 * 60));
                            const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                            displayText = `${hours} H : ${minutes} M : ${seconds} S`;

                            if (remainingTime <= 60 * 60 * 1000) { // Less than 1 hour
                                backgroundColor = 'red';
                                textColor = 'white';
                            } else if (remainingTime <= 3 * 60 * 60 * 1000) { // Less than 3 hours
                                backgroundColor = 'yellow';
                                textColor = 'black';
                            } else {
                                backgroundColor = 'white';
                                textColor = 'black';
                            }
                        }

                        cell.textContent = displayText;
                        cell.style.backgroundColor = backgroundColor;
                        cell.style.color = textColor;
                    }

                    updateCountdown();
                    setInterval(updateCountdown, 1000); // Update the countdown every second
                });
            }

            window.addEventListener('load', startCountdownForAllOrders);

        </script>


<script>
   function Deletion(id){
    Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('order.delete') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.success,
                            'success'
                        ).then(() => {
                            location.reload();
                        });;

                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON.error,
                            'error'
                        );
                    }
                });
            }
        });
        }
    </script>
    </x-slot>
</x-app-layout>
