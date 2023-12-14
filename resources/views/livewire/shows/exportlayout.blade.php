<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <span>Cooking Shows</span>
                <a href="#" class="btn btn-sm btn-primary" wire:click="export()"><i class="fa-solid fa-file-excel"></i> Export</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table">
                <table class="table table-sm table-hover table-bordered table-striped" style="font-size: 12px;">
                    <thead class="fw-bold table-light">
                        <tr>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Host</th>
                            <th>Contact No</th>
                            <th>Presenter</th>
                            <th>Lifechanger</th>
                            <th>Partner</th>
                            <th>Partner Type</th>
                            <th>Result</th>
                            <th>SSP Level</th>
                            <th>Assigned to Contest</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td>{{$row->type}}</td>
                            <td>{{\Carbon\Carbon::create($row->date)->format('M d, Y')}}</td>
                            <td>{{\Carbon\Carbon::create($row->time)->format('h:i A')}}</td>
                            <td>{{$row->host}}</td>
                            <td>{{$row->contact_no}}</td>
                            <td>{{$row->presenter}}</td>
                            <td>{{$row->lifechanger}}</td>
                            <td>{{$row->patner}}</td>
                            <td>{{$row->patner_type}}</td>
                            <td>{{$row->result}}</td>
                            <td>{{$row->sspl}}</td>
                            <td>{{$row->contest->title ?? ''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
