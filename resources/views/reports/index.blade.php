@extends('layouts.app')

@section('title', 'Reports | RetailPulse')

@section('content')
    <div x-data="reportsScreen(@js($reportTypes), @js($summaries), @js($rows), @js($comparisonSeries))" x-init="init()">
        <x-section-header
            title="Reports"
            description="Compare periods, inspect operational tables, and export results."
        />

        <section aria-labelledby="report-controls-heading" class="mt-6 border border-gray-300 bg-white p-4">
            <h2 id="report-controls-heading" class="sr-only">Report controls</h2>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label for="report-start" class="rp-label">Start date</label>
                    <input id="report-start" type="date" x-model="startDate" class="rp-field">
                </div>

                <div>
                    <label for="report-end" class="rp-label">End date</label>
                    <input id="report-end" type="date" x-model="endDate" class="rp-field">
                </div>

                <div>
                    <label for="report-type" class="rp-label">Report type</label>
                    <select id="report-type" x-model="reportType" class="rp-field">
                        @foreach ($reportTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="button" @click="applyFilters()" class="rp-button rp-button-primary flex-1">Apply</button>
                    <button type="button" @click="resetFilters()" class="rp-button rp-button-quiet flex-1">Reset</button>
                </div>
            </div>

            <p x-show="dateError" x-text="dateError" class="mt-3 text-sm font-medium text-gray-900"></p>
        </section>

        <section aria-labelledby="summary-heading" class="mt-8">
            <x-section-header title="Summary" description="Headline figures for the selected report." />

            <div x-show="loading" class="rp-scroll-row">
                @for ($i = 0; $i < 4; $i++)
                    <div class="rp-scroll-item">
                        <x-skeleton type="card" />
                    </div>
                @endfor
            </div>

            <div x-show="!loading" class="rp-scroll-row">
                <template x-for="card in currentSummary()" :key="card.title">
                    <article class="rp-scroll-item border border-gray-300 bg-white p-5">
                        <p class="text-sm font-medium text-gray-700" x-text="card.title"></p>
                        <p class="mt-3 text-2xl font-semibold text-gray-900" x-text="card.value"></p>
                        <p class="mt-2 text-sm text-gray-700">
                            <span x-text="card.direction === 'increase' ? '+' : (card.direction === 'decrease' ? '-' : '')"></span>
                            <span class="font-semibold" x-text="card.change"></span>
                            <span class="text-gray-600">versus previous period</span>
                        </p>
                    </article>
                </template>
            </div>
        </section>

        <section aria-labelledby="comparison-heading" class="mt-8">
            <x-section-header title="Period comparison" description="Current period against previous period." />

            <div class="border border-gray-300 bg-white p-5">
                <div x-show="loading" class="h-72">
                    <x-skeleton type="chart" />
                </div>

                <div x-show="!loading" class="h-72">
                    <canvas x-ref="comparisonChart"></canvas>
                </div>
            </div>
        </section>

        <section aria-labelledby="table-heading" class="mt-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-header title="Detail table" description="Row level results for the selected report." />

                <div class="flex gap-2 no-print">
                    <button type="button" @click="exportCsv()" class="rp-button">Export CSV</button>
                    <button type="button" @click="printReport()" class="rp-button">Print</button>
                </div>
            </div>

            <div x-show="loading" class="border border-gray-300 bg-white p-4">
                <x-skeleton type="row" />
                <div class="mt-4"><x-skeleton type="row" /></div>
                <div class="mt-4"><x-skeleton type="row" /></div>
            </div>

            <div x-show="!loading" class="mt-4 overflow-x-auto border border-gray-300 bg-white">
                <table id="report-table" class="rp-table">
                    <thead>
                        <tr>
                            <template x-for="column in currentColumns()" :key="column">
                                <th scope="col" x-text="column"></th>
                            </template>
                        </tr>
                    </thead>

                    <tbody>
                        <template x-for="(row, rowIndex) in currentRows()" :key="rowIndex">
                            <tr>
                                <template x-for="column in currentColumns()" :key="column">
                                    <td x-text="row[column.toLowerCase()]"></td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
