@extends('layouts.app')

@section('title', 'Staff | RetailPulse')

@section('content')
    <div x-data="staffManager(@js($staff))" x-init="init()">
        <x-section-header
            title="Staff management"
            description="Review team members, filter by branch, and manage access status."
        />

        <section aria-labelledby="staff-controls-heading" class="mt-6 border border-gray-300 bg-white p-4">
            <h2 id="staff-controls-heading" class="sr-only">Staff controls</h2>

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label for="staff-search" class="rp-label">Search</label>
                    <input
                        id="staff-search"
                        type="search"
                        x-model.debounce.300ms="query"
                        class="rp-field"
                        placeholder="Name or email"
                    >
                </div>

                <div>
                    <label for="staff-branch" class="rp-label">Branch</label>
                    <select id="staff-branch" x-model="branch" class="rp-field">
                        @foreach ($branches as $branchItem)
                            <option value="{{ $branchItem }}">{{ $branchItem }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="button" @click="openAddModal()" class="rp-button rp-button-primary w-full">
                        Add Staff
                    </button>
                </div>
            </div>
        </section>

        <div x-show="loading" class="mt-6 border border-gray-300 bg-white p-4">
            <x-skeleton type="row" />
            <div class="mt-4">
                <x-skeleton type="row" />
            </div>
            <div class="mt-4">
                <x-skeleton type="row" />
            </div>
        </div>

        <div x-show="!loading" class="mt-6">
            <x-data-table caption="Staff members">
                <thead>
                    <tr>
                        <th scope="col">Member</th>
                        <th scope="col">Role</th>
                        <th scope="col">Branch</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <template x-for="member in filtered()" :key="member.id">
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-9 w-9 items-center justify-center border border-gray-900 bg-white text-xs font-semibold text-gray-900" x-text="member.initials"></span>

                                    <div>
                                        <p class="font-medium text-gray-900" x-text="member.name"></p>
                                        <p class="text-sm text-gray-600" x-text="member.email"></p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <x-badge
                                    :variant="member.role === 'Admin' ? 'strong' : (member.role === 'Manager' ? 'default' : 'quiet')"
                                    x-text="member.role"
                                ></x-badge>
                            </td>

                            <td x-text="member.branch"></td>

                            <td>
                                <div class="flex items-center gap-3">
                                    <button
                                        type="button"
                                        role="switch"
                                        :aria-checked="member.active.toString()"
                                        @click="member.active = !member.active"
                                        class="relative h-6 w-12 border border-gray-500 bg-white cursor-pointer"
                                    >
                                        <span
                                            class="absolute top-1 h-4 w-4 bg-gray-900"
                                            x-bind:class="member.active ? 'left-7' : 'left-1'"
                                        ></span>
                                    </button>

                                    <span class="text-sm text-gray-700" x-text="member.active ? 'Active' : 'Inactive'"></span>
                                </div>
                            </td>

                            <td>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" @click="openEditModal(member)" class="rp-button rp-button-quiet px-3 py-1 text-xs">
                                        Edit
                                    </button>

                                    <button type="button" @click="confirmDelete(member)" class="rp-button rp-button-quiet px-3 py-1 text-xs">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <tr x-show="filtered().length === 0">
                        <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-700">
                            No staff members match the current filters.
                        </td>
                    </tr>
                </tbody>
            </x-data-table>
        </div>

        <x-modal name="addModalOpen" title="Add staff member">
            <form @submit.prevent="saveStaff()" class="grid gap-4">
                <div>
                    <label for="add-name" class="rp-label">Full name</label>
                    <input id="add-name" type="text" x-model="form.name" class="rp-field" required>
                </div>

                <div>
                    <label for="add-email" class="rp-label">Email</label>
                    <input id="add-email" type="email" x-model="form.email" class="rp-field" required>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="add-role" class="rp-label">Role</label>
                        <select id="add-role" x-model="form.role" class="rp-field">
                            <option>Admin</option>
                            <option>Manager</option>
                            <option>Cashier</option>
                        </select>
                    </div>

                    <div>
                        <label for="add-branch" class="rp-label">Branch</label>
                        <select id="add-branch" x-model="form.branch" class="rp-field">
                            @foreach (array_slice($branches, 1) as $branchItem)
                                <option value="{{ $branchItem }}">{{ $branchItem }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        role="switch"
                        :aria-checked="form.active.toString()"
                        @click="form.active = !form.active"
                        class="relative h-6 w-12 border border-gray-500 bg-white cursor-pointer"
                    >
                        <span
                            class="absolute top-1 h-4 w-4 bg-gray-900"
                            x-bind:class="form.active ? 'left-7' : 'left-1'"
                        ></span>
                    </button>

                    <span class="text-sm text-gray-800">Active account</span>
                </div>

                <p x-show="formError" x-text="formError" class="text-sm font-medium text-gray-900"></p>
            </form>

            <x-slot:footer>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="addModalOpen = false" class="rp-button rp-button-quiet">Cancel</button>
                    <button type="button" @click="saveStaff()" class="rp-button rp-button-primary">Save member</button>
                </div>
            </x-slot:footer>
        </x-modal>

        <x-modal name="editModalOpen" title="Edit staff member">
            <form @submit.prevent="updateStaff()" class="grid gap-4">
                <div>
                    <label for="edit-name" class="rp-label">Full name</label>
                    <input id="edit-name" type="text" x-model="editForm.name" class="rp-field" required>
                </div>

                <div>
                    <label for="edit-email" class="rp-label">Email</label>
                    <input id="edit-email" type="email" x-model="editForm.email" class="rp-field" required>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="edit-role" class="rp-label">Role</label>
                        <select id="edit-role" x-model="editForm.role" class="rp-field">
                            <option>Admin</option>
                            <option>Manager</option>
                            <option>Cashier</option>
                        </select>
                    </div>

                    <div>
                        <label for="edit-branch" class="rp-label">Branch</label>
                        <select id="edit-branch" x-model="editForm.branch" class="rp-field">
                            @foreach (array_slice($branches, 1) as $branchItem)
                                <option value="{{ $branchItem }}">{{ $branchItem }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <x-slot:footer>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="editModalOpen = false" class="rp-button rp-button-quiet">Cancel</button>
                    <button type="button" @click="updateStaff()" class="rp-button rp-button-primary">Update member</button>
                </div>
            </x-slot:footer>
        </x-modal>

        <x-confirm-dialog
            open="deleteModalOpen"
            title="Delete staff member"
            message="This action will remove the selected staff record from the active roster."
            confirm-label="Delete member"
            cancel-label="Keep member"
        />
    </div>
@endsection
