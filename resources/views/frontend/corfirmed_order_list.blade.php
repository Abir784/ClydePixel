<x-app-layout>
    <x-slot name="header">Completed Orders</x-slot>
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
                            <th scope="col">Completed At</th>
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
                                @php
                                $hour = floor(Carbon\Carbon::parse($order->created_at)->timezone('Asia/Dhaka')->diffInHours($order->deadline));
                                $minutes=Carbon\Carbon::parse($order->created_at)->timezone('Asia/Dhaka')->diffInMinutes($order->deadline) % 60;
                                @endphp

                                {{$hour.' H '.' : '.$minutes.' M'}}
                            </td>
                            <td >{{Carbon\Carbon::parse($order->updated_at)->format('d-M-y')}} <br>
                                {{Carbon\Carbon::parse($order->updated_at)->format('H:i A')}}</td>
                            <td> <a href="{{route('order.view',$order->id)}}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                            </a></td>
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

    </x-slot>
</x-app-layout>
