<div class="col-md-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Recently Orders</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                @if(!$last_orders->isEmpty())
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Buyer</th>
                            <th>Status</th>
                            <th>Summary</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($last_orders as $order)
                            <tr>
                                <td><a href="{{route('shop.admin.orders.edit', $order->id)}}">{{$order->id}}</a></td>
                                <td>
                                    <a href="{{route('shop.admin.orders.edit', $order->id)}}">{{ucfirst($order->name)}}</a>
                                </td>
                                <?php
                                switch ($order->status) {
                                    case 0:
                                        $class = 'primary';
                                        break;
                                    case 1:
                                        $class = 'success';
                                        break;
                                    case 2:
                                        $class = 'danger';
                                        break;
                                    case 3:
                                        $class = 'warning';
                                        break;
                                }
                                ?>
                                <td><span class="label label-{{$class}}">
                                @if ($order->status == 0) NEW!
                                        @endif
                                        @if ($order->status == 1) Completed
                                        @endif
                                        @if ($order->status == 2) Deleted
                                        @endif
                                        @if ($order->status == 3) On Order Preparation
                                        @endif
                            </span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">{{$order->sum}}</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <br><span class="warning text-center"><i
                                class="fa fa-fw fa-warning"></i>No Data To View!</span>
                @endif
            </div>
        </div>

        <br>

        <div class="box-footer clearfix">
            <a href="{{route('shop.admin.orders.index')}}" class="btn btn-sm btn-info btn-flat pull-left">All Orders</a>
        </div>

    </div>
</div>