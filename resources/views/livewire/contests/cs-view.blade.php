<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-project-diagram la-lg"></i> Contests
            </li>
            <li>
                <i class="mr-1 las la-eye la-lg"></i> View
            </li>
            <li>
                {{ $contest->serial() }}
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col px-3 py-5 mx-auto max-w-screen-2xl">
    <div class="p-5 bg-white rounded-md shadow-md">
        <div class="flex flex-col justify-center px-2 mx-auto text-center">
            <span class="text-xl font-black uppercase">{{ $contest->title }}</span>
            <span class="text-xl font-semibold uppercase">{{ $contest->serial() }}</span>
        </div>

        <div id="printDiv">
            <div class="flex justify-between gap-2 px-2 mb-3 font-bold">
                <div class="flex flex-col">
                    <span>{{ $contest->description }}</span>
                    <span>Contest Duration: {{ $contest->start_date }} to {{ $contest->end_date }}</span>
                    <span>Days Remaining: {{ $dt->diffInDays($contest->end_date) }}</span>
                    <span>Restriction: <span class="uppercase">{{ $contest->restriction }}
                            {{ $contest->restriction == 'level' ? ': ' . $contest->sspl->level : '' }}</span></span>
                </div>
                <div class="flex flex-col">
                    <span>Required Shows: {{ $contest->shows }}</span>
                    <span>Required Sales: {{ number_format($contest->sales, 2) }}</span>
                    <span>Required Sets: {{ number_format($contest->sets, 2) }} </span>
                </div>
            </div>
            <hr>
            <div class="table">
                <table class="table table-hover table-sm" style="font-size: 12px;">
                    <thead class="fw-bold table-light">
                        <tr>
                            <th>#</th>
                            <th>Lifechanger</th>
                            <th class="text-center">Shows</th>
                            <th class="text-center">Sales</th>
                            <th class="text-center">Sets</th>
                            {{-- <th></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td class="uppercase">{{ $loop->iteration }}</td>
                                <td class="uppercase">
                                    {{ $contest->for_team_builders ? $row->team_builder : $row->lifechanger }}</td>
                                <td class="text-center">
                                    <div class="flex flex-col justify-center">
                                        <span>{{ $row->shows }}/{{ $contest->shows }}</span>
                                        <progress class="w-56 mx-auto progress progress-warning"
                                            value="{{ $row->shows }}" max="{{ $contest->shows }}">
                                        </progress>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="flex flex-col justify-center">
                                        <span>{{ number_format($row->sales, 2) }}/{{ number_format($contest->sales, 2) }}</span>
                                        <progress class="w-56 mx-auto progress progress-success"
                                            value="{{ $row->sales }}"
                                            max="{{ $contest->sales }}">{{ number_format($row->sales, 2) }} /
                                        </progress>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="flex flex-col justify-center">
                                        <span>{{ number_format($row->sets, 2) }}/{{ number_format($contest->sets, 2) }}</span>
                                        <progress class="w-56 mx-auto progress progress-primary"
                                            value="{{ $row->sets }}"
                                            max="{{ $contest->sets }}">{{ number_format($row->sets, 2) }} /
                                        </progress>
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
