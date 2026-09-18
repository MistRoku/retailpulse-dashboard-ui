@extends('layouts.app')

@section('title', 'Dashboard | RetailPulse')

@section('content')
    <div x-data="dashboardHome" x-init="init()">
        <x-section-header
            title="Store performance overview"
            description="Today activity across all branches."
        />

        <section aria-labelledby="kpi-heading" class="mt-6">
            <h2 id="kpi-heading" class="sr-only">Key metrics</h2>

            <div x-show="loading" class="rp-scroll-row">
                @for ($i = 0; $i < 4; $i++)
                    <div class="rp-scroll-item">
                        <x-skeleton type="card" />
                    </div>
                @endfor
            </div>

            <x-scroller x-show="!loading" label="Key metrics">
                @foreach ($kpis as $kpi)
                    <x-stat-card
                        :title="$kpi['title']"
                        :value="$kpi['value']"
                        :change="$kpi['change']"
                        :direction="$kpi['direction']"
                        :comparison="$kpi['comparison']"
                    />
                @endforeach
            </x-scroller>
        </section>

        <section aria-labelledby="charts-heading" class="mt-8">
            <h2 id="charts-heading" class="sr-only">Charts</h2>

            <div class="grid gap-6 xl:grid-cols-2">
                <div class="border border-gray-300 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">Revenue, last 7 days</h3>
                    </div>

                    <div x-show="chartLoading" class="mt-5">
                        <x-skeleton type="chart" />
                    </div>

                    <div x-show="!chartLoading" class="mt-5 h-72">
                        <canvas x-ref="revenueChart"></canvas>
                    </div>
                </div>

                <div class="border border-gray-300 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">Top selling products</h3>
                    </div>

                    <div x-show="chartLoading" class="mt-5">
                        <x-skeleton type="chart" />
                    </div>

                    <div x-show="!chartLoading" class="mt-5 h-72">
                        <canvas x-ref="topProductsChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <section aria-labelledby="quick-actions-heading" class="mt-8">
            <h2 id="quick-actions-heading" class="sr-only">Quick actions</h2>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('pos.terminal') }}" class="rp-button rp-button-primary">New Sale</a>
                <a href="{{ route('products.index') }}" class="rp-button">Add Product</a>
                <a href="{{ route('reports.index') }}" class="rp-button">Generate Report</a>
            </div>
        </section>

        <section aria-labelledby="transactions-heading" class="mt-8">
            <x-section-header
                title="Recent transactions"
                description="Latest ten transactions across branches."
            />

            <x-data-table caption="Recent transactions">
                <thead>
                    <tr>
                        <th scope="col">Reference</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Channel</th>
                        <th scope="col">Status</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>

                <tbody x-show="tableLoading">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td><x-skeleton type="line" width="w-24" /></td>
                            <td><x-skeleton type="line" width="w-32" /></td>
                            <td><x-skeleton type="line" width="w-16" /></td>
                            <td><x-skeleton type="line" width="w-20" /></td>
                            <td><x-skeleton type="line" width="w-24" /></td>
                            <td><x-skeleton type="line" width="w-14" /></td>
                        </tr>
                    @endfor
                </tbody>

                <tbody x-show="!tableLoading">
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td class="font-medium text-gray-900">{{ $transaction['reference'] }}</td>
                            <td>{{ $transaction['customer'] }}</td>
                            <td>{{ $transaction['amount'] }}</td>
                            <td>{{ $transaction['channel'] }}</td>
                            <td>
                                <x-badge :variant="$transaction['status'] === 'Completed' ? 'strong' : ($transaction['status'] === 'Failed' ? 'strong' : 'default')">
                                    {{ $transaction['status'] }}
                                </x-badge>
                            </td>
                            <td>{{ $transaction['time'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-data-table>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:initialized', () => {
            window.dashboardSeed = @json([
                'revenue' => $revenueSeries,
                'topProducts' => $topProducts,
            ]);
        });
    </script>
@endpush
