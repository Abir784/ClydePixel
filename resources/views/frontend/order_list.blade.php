<x-app-layout>
    <x-slot name="header">Recent Orders</x-slot>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
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
                            <th scope="col">Total Time</th>
                            <th scope="col">Remaining Time</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_list as $key=>$order )
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
                                {{Carbon\Carbon::parse($order->created_at)->timezone('Asia/Dhaka')->format('d-M-y')}} <br>
                                {{Carbon\Carbon::parse($order->created_at)->timezone('Asia/Dhaka')->format('h:i A')}}
                            </td>
                            <td data-created-at="{{ $order->created_at }}" data-deadline="{{ $order->deadline }}"></td>
                            <td>
                                {{Carbon\Carbon::parse($order->deadline)->format('d-M-y')}} <br>
                                {{Carbon\Carbon::parse($order->deadline)->format('H:i A')}}
                            </td>
                            <td>

                                <div class="btn-group dropdown">
                                    <button class="btn text-warning-600 hover-text-warning px-18 py-11 dropdown-toggle toggle-icon icon-down" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if($order->status == 0)
                                         Pending
                                        @elseif ($order->status==1)
                                        Working
                                        @elseif ($order->status==2)
                                        QC1
                                        @elseif ($order->status==3)
                                        QC2
                                        @elseif ($order->status==4)
                                        Done
                                        @elseif ($order->status==5)
                                        Completed
                                        @endif

                                    </button>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="{{route('order.status',['status'=>0,'id'=>$order->id])}}">Pending</a></li>
                                      <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="{{route('order.status',['status'=>1,'id'=>$order->id])}}">Working</a></li>
                                      <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="{{route('order.status',['status'=>2,'id'=>$order->id])}}">QC1</a></li>
                                      <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="{{route('order.status',['status'=>3,'id'=>$order->id])}}">QC2</a></li>
                                      <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="{{route('order.status',['status'=>4,'id'=>$order->id])}}">Done</a></li>
                                      <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="{{route('order.status',['status'=>5,'id'=>$order->id])}}">Completed</a></li>
                                    </ul>
                                </div>
                            <td>
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    <a href="{{route('order.view',$order->id)}}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                    </a>
                                @if (Auth::user()->role !=2)
                                   <button type="button" onclick="Deletion('{{$order->id}}')" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                @endif
                             </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-3 mt-3">
        {{ $order_list->links() }}
    </div>

    <x-slot name="script">
        <script>
        function startCountdownForAllOrders() {
                const timerCells = document.querySelectorAll('[data-created-at]');

                timerCells.forEach((cell) => {
                    const deadline = new Date(cell.getAttribute('data-deadline')).getTime();

                    function updateCountdown() {
                        const now = Date.now();
                        const remainingTime = deadline - now;

                        let displayText, backgroundColor, textColor;

                        if (remainingTime <= 0) {
                            // Time has passed the deadline, show the elapsed time
                            const elapsedTime = Math.abs(remainingTime);
                            const hours = Math.floor((elapsedTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

                            displayText = `-${hours} H : ${minutes} M : ${seconds} S`;
                            backgroundColor = 'red'; // Light red background for passed deadline
                            textColor = 'black';

                        } else {
                            // Time remaining until the deadline
                            const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
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
