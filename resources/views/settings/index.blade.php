@extends('layouts.app')

@section('title', 'Settings | RetailPulse')

@section('content')
    <div x-data="settingsForms" x-init="init()">
        <x-section-header
            title="Settings"
            description="Configure branch details, tax behavior, receipts, notifications, and your profile."
        />

        <div class="mt-6 grid gap-6 xl:grid-cols-2">
            <section aria-labelledby="branch-settings-heading" class="border border-gray-300 bg-white p-5">
                <h2 id="branch-settings-heading" class="text-base font-semibold text-gray-900">Branch settings</h2>

                <form @submit.prevent="saveSection('branch')" class="mt-5 grid gap-4">
                    <div>
                        <label for="branch-name" class="rp-label">Branch name</label>
                        <input id="branch-name" type="text" x-model="branch.name" class="rp-field">
                    </div>

                    <div>
                        <label for="branch-address" class="rp-label">Address</label>
                        <textarea id="branch-address" x-model="branch.address" rows="3" class="rp-field"></textarea>
                    </div>

                    <div>
                        <label for="branch-phone" class="rp-label">Phone</label>
                        <input id="branch-phone" type="tel" x-model="branch.phone" class="rp-field">
                    </div>

                    <div>
                        <span class="rp-label">Logo</span>

                        <div class="border border-dashed border-gray-400 bg-white p-5 text-center">
                            <img
                                x-show="logoPreview"
                                :src="logoPreview"
                                alt="Branch logo preview"
                                class="mx-auto h-24 w-24 border border-gray-300 bg-white object-contain"
                            >

                            <p x-show="!logoPreview" class="text-sm text-gray-700">
                        Upload a square logo for receipts and invoices.
                    </p>

                            <input
                                type="file"
                                x-ref="logoInput"
                                @change="handleLogoUpload"
                                accept="image/png,image/jpeg,image/svg+xml"
                                class="sr-only"
                            >

                            <button type="button" @click="$refs.logoInput.click()" class="rp-button mt-4">
                                Choose file
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="rp-button rp-button-primary">Save branch settings</button>
                        <p x-show="savedSection === 'branch'" class="text-sm font-medium text-gray-900">Changes saved.</p>
                    </div>
                </form>
            </section>

            <section aria-labelledby="tax-receipt-heading" class="border border-gray-300 bg-white p-5">
                <h2 id="tax-receipt-heading" class="text-base font-semibold text-gray-900">Tax and receipt</h2>

                <form @submit.prevent="saveSection('tax')" class="mt-5 grid gap-4">
                    <div>
                        <label for="tax-rate" class="rp-label">Tax rate</label>
                        <input id="tax-rate" type="number" min="0" step="0.01" x-model.number="tax.rate" class="rp-field">
                    </div>

                    <div>
                        <label for="receipt-header" class="rp-label">Receipt header</label>
                        <input id="receipt-header" type="text" x-model="receipt.header" class="rp-field">
                    </div>

                    <div>
                        <label for="receipt-footer" class="rp-label">Receipt footer</label>
                        <textarea id="receipt-footer" x-model="receipt.footer" rows="3" class="rp-field"></textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="rp-button rp-button-primary">Save tax settings</button>
                        <p x-show="savedSection === 'tax'" class="text-sm font-medium text-gray-900">Changes saved.</p>
                    </div>
                </form>
            </section>

            <section aria-labelledby="notification-heading" class="border border-gray-300 bg-white p-5">
                <h2 id="notification-heading" class="text-base font-semibold text-gray-900">Notification preferences</h2>

                <div class="mt-5 divide-y divide-gray-200">
                    <div class="flex items-center justify-between gap-4 py-4">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Low stock alerts</p>
                            <p class="mt-1 text-sm text-gray-700">Receive alerts when inventory falls below threshold.</p>
                        </div>

                        <button
                            type="button"
                            role="switch"
                            :aria-checked="notifications.lowStock.toString()"
                            @click="notifications.lowStock = !notifications.lowStock"
                            class="relative h-6 w-12 border border-gray-500 bg-white cursor-pointer"
                        >
                            <span
                                class="absolute top-1 h-4 w-4 bg-gray-900"
                                x-bind:class="notifications.lowStock ? 'left-7' : 'left-1'"
                            ></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-4 py-4">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Daily sales digest</p>
                            <p class="mt-1 text-sm text-gray-700">Get a summary at the end of each business day.</p>
                        </div>

                        <button
                            type="button"
                            role="switch"
                            :aria-checked="notifications.dailyDigest.toString()"
                            @click="notifications.dailyDigest = !notifications.dailyDigest"
                            class="relative h-6 w-12 border border-gray-500 bg-white cursor-pointer"
                        >
                            <span
                                class="absolute top-1 h-4 w-4 bg-gray-900"
                                x-bind:class="notifications.dailyDigest ? 'left-7' : 'left-1'"
                            ></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-4 py-4">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Staff account changes</p>
                            <p class="mt-1 text-sm text-gray-700">Notify when roles or access status change.</p>
                        </div>

                        <button
                            type="button"
                            role="switch"
                            :aria-checked="notifications.staffChanges.toString()"
                            @click="notifications.staffChanges = !notifications.staffChanges"
                            class="relative h-6 w-12 border border-gray-500 bg-white cursor-pointer"
                        >
                            <span
                                class="absolute top-1 h-4 w-4 bg-gray-900"
                                x-bind:class="notifications.staffChanges ? 'left-7' : 'left-1'"
                            ></span>
                        </button>
                    </div>
                </div>
            </section>

            <section aria-labelledby="profile-heading" class="border border-gray-300 bg-white p-5">
                <h2 id="profile-heading" class="text-base font-semibold text-gray-900">User profile</h2>

                <form @submit.prevent="saveProfile" class="mt-5 grid gap-4">
                    <div>
                        <label for="profile-name" class="rp-label">Name</label>
                        <input id="profile-name" type="text" x-model="profile.name" class="rp-field">
                    </div>

                    <div>
                        <label for="profile-email" class="rp-label">Email</label>
                        <input id="profile-email" type="email" x-model="profile.email" class="rp-field">
                    </div>

                    <div>
                        <label for="current-password" class="rp-label">Current password</label>
                        <input id="current-password" type="password" x-model="profile.currentPassword" class="rp-field">
                    </div>

                    <div>
                        <label for="new-password" class="rp-label">New password</label>
                        <input id="new-password" type="password" x-model="profile.newPassword" class="rp-field">
                        <p class="mt-2 text-sm text-gray-700">
                            Use at least twelve characters with letters and numbers.
                        </p>
                    </div>

                    <div>
                        <label for="confirm-password" class="rp-label">Confirm new password</label>
                        <input id="confirm-password" type="password" x-model="profile.confirmPassword" class="rp-field">
                    </div>

                    <p x-show="profileError" x-text="profileError" class="text-sm font-medium text-gray-900"></p>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="rp-button rp-button-primary">Save profile</button>
                        <p x-show="savedSection === 'profile'" class="text-sm font-medium text-gray-900">Profile updated.</p>
                    </div>
                </form>
            </section>
        </div>

        <section aria-labelledby="legal-heading" class="mt-8 border border-gray-300 bg-white p-5">
            <h2 id="legal-heading" class="text-base font-semibold text-gray-900">Legal</h2>

            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('legal.terms') }}" class="rp-button">Terms of Service</a>
                <a href="{{ route('legal.privacy') }}" class="rp-button">Privacy Policy</a>
            </div>
        </section>
    </div>
@endsection
