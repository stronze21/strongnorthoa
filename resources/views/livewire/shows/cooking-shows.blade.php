<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <span>Cooking Shows</span>
                <div class="d-flex">
                    <div class="col me-2">
                        <input class="form-control form-control-sm" type="date" wire:model.defer="start_rep">
                    </div>
                    <div class="col me-2">
                        <input class="form-control form-control-sm" type="date" wire:model.defer="end_rep">
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-sm btn-primary" wire:click="export()"><i
                                class="fa-solid fa-file-excel"></i> Export</a>
                    </div>
                </div>
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
                    <tbody class="text-uppercase">
                        @foreach ($data as $row)
                            <tr class="{{ $selected_cs == $row ? 'table-primary' : '' }}"
                                wire:click="show_cs({{ $row->cs_id }})" data-bs-toggle="modal"
                                data-bs-target="#newContest">
                                <td>{{ $row->type }}</td>
                                <td>{{ \Carbon\Carbon::create($row->date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::create($row->time)->format('h:i A') }}</td>
                                <td>{{ $row->host }}</td>
                                <td>{{ $row->contact_no }}</td>
                                <td>{{ $row->presenter }}</td>
                                <td>{{ $row->lifechanger }}</td>
                                <td>{{ $row->partner_id ? $row->partner_user->fullname() : '' }}</td>
                                <td>{{ $row->patner_type }}</td>
                                <td>{{ $row->result }}</td>
                                <td>{{ $row->sspl }}</td>
                                <td>{{ $row->contest->title ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="newContest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="newContestLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newContestLabel">Assign Cooking Show to Contest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-3 modal-body">

                    @if ($show)
                        <table class="table table-sm">
                            <tr>
                                <th class="fw-bold">Type</th>
                                <td>{{ $selected_cs->type }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Date</th>
                                <td>{{ \Carbon\Carbon::create($selected_cs->date)->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Time</th>
                                <td>{{ \Carbon\Carbon::create($selected_cs->time)->format('h:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Host</th>
                                <td>{{ $selected_cs->host }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Contact No</th>
                                <td>{{ $selected_cs->contact_no }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Presenter</th>
                                <td>{{ $selected_cs->presenter }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Lifechanger</th>
                                <td>{{ $selected_cs->lifechanger }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Partner</th>
                                <td>{{ $selected_cs->patner }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Partner Type</th>
                                <td>{{ $selected_cs->patner_type }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Result</th>
                                <td>{{ $selected_cs->result }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bold">SSP Level</th>
                                <td>{{ $selected_cs->sspl }}</td>
                            </tr>
                        </table>
                        <div class="p-3 form-group bg-light">
                            <label class="form-label" for="contest_id">Assign to Contest</label>
                            <select id="contest_id" class="form-select form-select-sm me-1"
                                wire:model.defer="contest_id">
                                <option value="null">None</option>
                                @forelse ($contests as $contest)
                                    <option value="{{ $contest->id }}">{{ $contest->title }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="hide_cs()">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="save()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
</div>
