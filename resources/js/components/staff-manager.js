export function staffManager(initialStaff) {
    return {
        loading: true,
        query: '',
        branch: 'All Branches',
        staff: initialStaff,
        addModalOpen: false,
        editModalOpen: false,
        deleteModalOpen: false,
        formError: '',
        form: {
            name: '',
            email: '',
            role: 'Cashier',
            branch: 'Downtown Flagship',
            active: true,
        },
        editForm: {
            id: null,
            name: '',
            email: '',
            role: 'Cashier',
            branch: 'Downtown Flagship',
            active: true,
        },

        init() {
            window.setTimeout(() => {
                this.loading = false;
            }, 300);
        },

        filtered() {
            const query = this.query.trim().toLowerCase();

            return this.staff.filter((member) => {
                const matchesQuery =
                    member.name.toLowerCase().includes(query) ||
                    member.email.toLowerCase().includes(query);

                const matchesBranch =
                    this.branch === 'All Branches' || member.branch === this.branch;

                return matchesQuery && matchesBranch;
            });
        },

        openAddModal() {
            this.form = {
                name: '',
                email: '',
                role: 'Cashier',
                branch: 'Downtown Flagship',
                active: true,
            };

            this.formError = '';
            this.addModalOpen = true;
        },

        saveStaff() {
            if (!this.form.name.trim() || !this.form.email.trim()) {
                this.formError = 'Name and email are required.';
                return;
            }

            const initials = this.form.name
                .trim()
                .split(' ')
                .slice(0, 2)
                .map((part) => part[0])
                .join('')
                .toUpperCase();

            this.staff.unshift({
                id: Date.now(),
                name: this.form.name,
                email: this.form.email,
                role: this.form.role,
                branch: this.form.branch,
                active: this.form.active,
                initials,
            });

            this.addModalOpen = false;
        },

        openEditModal(member) {
            this.editForm = { ...member };
            this.editModalOpen = true;
        },

        updateStaff() {
            const index = this.staff.findIndex((member) => member.id === this.editForm.id);

            if (index !== -1) {
                this.staff[index] = {
                    ...this.staff[index],
                    ...this.editForm,
                    initials: this.editForm.name
                        .trim()
                        .split(' ')
                        .slice(0, 2)
                        .map((part) => part[0])
                        .join('')
                        .toUpperCase(),
                };
            }

            this.editModalOpen = false;
        },

        confirmDelete(member) {
            this.deleteModalOpen = true;
        },
    };
}
