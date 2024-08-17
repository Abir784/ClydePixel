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
                        <td>{{Carbon\Carbon::parse($order->deadline)->format('d-M-Y h:i A')}}</td>
                        <th scope="col">Status</th>
                        <td>
                            @if($order->status != 5)
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

                            @else
                             Completed At {{Carbon\Carbon::parse($order->updated_at)->format('d-m-Y h:i A')}} <br> By {{$order->updated_by->name}}

                            @endif


                        </td>
                      </tr>
                      <tr >
                        <th scope="col" colspan="2">Type of work</th>
                        <th scope="col" colspan="2">Number of files</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if($order->simple_clipping!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Simple Clipping</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->simple_clipping}}</td>
                          </tr>
                        @endif

                        @if($order->in_clip_2_in_1!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">In Clip 2 in 1</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->in_clip_2_in_1}}</td>
                          </tr>
                        @endif

                        @if($order->in_clip_3_in_1!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">In Clip 3 in 1</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->in_clip_3_in_1}}</td>
                          </tr>
                        @endif

                        @if($order->layer_masking!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Layer Masking</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->layer_masking}}</td>
                          </tr>
                        @endif


                        @if($order->retouch!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Retouch</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->retouch}}</td>
                          </tr>
                        @endif

                        @if($order->nechjoin!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Neckjoin</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->nechjoin}}</td>
                          </tr>
                        @endif

                        @if($order->recolor!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Recolor</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->recolor}}</td>
                          </tr>
                        @endif
                        @if($order->neek_joint_wit_lequefy!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Neek Joint with Lequefy</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->neek_joint_wit_lequefy}}</td>
                          </tr>
                        @endif
                        @if($order->clipping_with_liquefy!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Clipping With Liquefy</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->clipping_with_liquefy}}</td>
                          </tr>
                        @endif

                        @if($order->vector_graphics!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Vector Graphics</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->vector_graphics}}</td>
                          </tr>
                        @endif
                        @if($order->complex_multi_path!=null)
                        <tr>
                            <td colspan="2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                  <h6 class="text-md mb-0 fw-normal">Complex Multi Path</h6>
                                </div>
                              </div>
                            </td>
                            <td colspan="2">{{$order->complex_multi_path}}</td>
                          </tr>
                        @endif @if($order->complex_multi_path!=null)
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
