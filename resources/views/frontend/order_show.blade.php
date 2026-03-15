<x-app-layout>
    <x-slot name="header">
        Order Details
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table striped-table mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Name: </th>
                        <td>{{$order->name}}</td>
                        <th scope="col">Folder Name:</th>
                        <td>{{$order->folder_name}}</td>
                      </tr>
                      <tr>
                        <th scope="col">Ordered By: </th>
                        <td>{{$order->order_by->name}}</td>
                        <th scope="col">Total Files:</th>
                        <td>{{$order->total_file}}</td>
                      </tr>
                      <tr>
                        <th scope="col">Deadline: </th>
                        <td>{{Carbon\Carbon::parse($order->deadline)->timezone(config('app.timezone'))->format('d-M-Y h:i A')}}</td>
                        <th scope="col">Status</th>
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

                          @if($order->status != 5)
                            @if (Auth::user()->role == 0 || Auth::user()->role == 1)
                              <div class="btn-group dropdown">
                                <button class="btn text-warning-600 hover-text-warning px-18 py-11 dropdown-toggle toggle-icon icon-down" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  {{ $statusText }}
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
                            @else
                              <span class="badge bg-neutral-200 text-dark">{{ $statusText }}</span>
                            @endif
                          @else
                           Completed At {{Carbon\Carbon::parse($order->updated_at)->timezone(config('app.timezone'))->format('d-m-Y h:i A')}} <br> By {{$order->updated_by->name}}
                          @endif


                        </td>
                      </tr>
                      <tr >
                        <th scope="col" colspan="2">Type of work</th>
                        <th scope="col" colspan="2">Number of files</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderWorkItems as $workItem)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">{{ $workItem['label'] }}</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{ $workItem['value'] }}</td>
                          </tr>
                        @empty
                        <tr>
                            <td colspan="4">No work items found for this order.</td>
                        </tr>
                        @endforelse

                        @if($order->comment!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal"> Comment</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->comment}}</td>
                          </tr>
                        @endif
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
    </div>
    <x-slot name="script">

    </x-slot>
</x-app-layout>
