<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li>
                <i class="mr-1 las la-tachometer-alt la-lg"></i> Dashboard
            </li>
        </ul>
    </div>
</x-slot>


<div class="py-12 ">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="p-5 overflow-hidden sm:rounded-lg ">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                <div class="text-white shadow-lg bg-secondary card">
                    <div class="card-body">
                        <h2 class="card-title">Booked Shows</h2>
                        <p class="text-5xl text-right">{{$booked_shows}}</p>
                    </div>
                </div>
                <div class="text-white shadow-lg bg-error card">
                    <div class="card-body">
                        <h2 class="card-title">Expired Shows</h2>
                        <p class="text-5xl text-right">{{$expired_shows}}</p>
                    </div>
                </div>
                <div class="text-white shadow-lg bg-primary card">
                    <div class="card-body">
                        <h2 class="card-title">Cooked Shows</h2>
                        <p class="text-5xl text-right">{{$cooked_shows}}</p>
                    </div>
                </div>
                <div class="text-white shadow-lg bg-success card">
                    <div class="card-body">
                        <h2 class="card-title">Closed Shows</h2>
                        <p class="text-5xl text-right">{{$closed_shows}}</p>
                    </div>
                </div>
                <div class="text-white shadow-lg bg-warning card">
                    <div class="card-body">
                        <h2 class="card-title">Amount Sold (Reported)</h2>
                        <p class="text-5xl text-right">{{number_format($sets_sold, 2)}}</p>
                    </div>
                </div>
                <div class="text-white shadow-lg bg-info card">
                    <div class="card-body">
                        <h2 class="card-title">Set Sold (Reported)</h2>
                        <p class="text-5xl text-right">{{$sets_sold ? $sets_sold/$settings->set_amount : 0}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
