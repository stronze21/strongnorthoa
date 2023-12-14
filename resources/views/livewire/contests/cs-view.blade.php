<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <span>Contest Title: <span class="fw-bolder text-uppercase">{{$contest->title}}</span></span>
                <div class="d-flex">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text" id="search"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input class="form-control form-control-sm" type="text" wire:model.lazy="search" aria-label="Search" aria-describedby="search">
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body" id="printDiv">
            <div class="px-2 mb-3 fw-bold d-flex justify-content-between">
                <div>
                    <span class="row">{{$contest->description}}</span>
                    <span class="row">Contest Duration: {{$contest->start_date}} to {{$contest->end_date}}</span>
                    <span class="row">Days Remaining: {{$dt->diffInDays($contest->end_date)}}</span>
                </div>
                <div class="me-5">
                    <span class="row">Required Shows: {{$contest->shows}}</span>
                    <span class="row">Required Sales: {{number_format($contest->sales,2)}}</span>
                    <span class="row">Required Sets: {{number_format($contest->sets,2)}} </span>
                </div>
            </div>
            <hr>
            <div class="table">
                <table class="table table-hover table-bordered table-striped" style="font-size: 12px;">
                    <thead class="fw-bold table-light">
                        <tr>
                            <th>Lifechanger</th>
                            <th>Shows</th>
                            <th>Sales</th>
                            <th>Sets</th>
                            {{-- <th></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td class="text-uppercase">{{$row->lifechanger}}</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: @if($contest->shows != 0) {{($row->shows/$contest->shows)*100}}%@else 100% @endif" aria-valuenow="{{$row->shows}}" aria-valuemin="0" aria-valuemax="{{$contest->shows}}">{{$row->shows}}/{{$contest->shows}}</div>
                                </div>
                            </td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: @if($contest->sales != 0) {{($row->sales/$contest->sales)*100}}%@else 100% @endif" aria-valuenow="{{$row->sales}}" aria-valuemin="0" aria-valuemax="{{$contest->sales}}">{{number_format($row->sales,2)}} / {{number_format($contest->sales,2)}}</div>
                                </div>
                            </td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: @if($contest->sets != 0) {{($row->sets/$contest->sets)*100}}%@else 100% @endif" aria-valuenow="{{$row->sets}}" aria-valuemin="0" aria-valuemax="{{$contest->sets}}">{{number_format($row->sets,2)}} / {{number_format($contest->sets,2)}}</div>
                                </div>
                            </td>
                            {{-- <td></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

