export function settingsForms() {
    return {
        savedSection: '',
        profileError: '',
        logoPreview: '',

        branch: {
            name: 'Downtown Flagship',
            address: '118 Market Street, Suite 200',
            phone: '+1 555 0142',
        },

        tax: {
            rate: 7.5,
        },

        receipt: {
            header: 'Thank you for shopping with RetailPulse.',
            footer: 'Returns accepted within 30 days with receipt.',
        },

        notifications: {
            lowStock: true,
            dailyDigest: true,
            staffChanges: false,
        },

        profile: {
            name: 'Nadia Rahman',
            email: 'nadia.rahman@retailpulse.test',
            currentPassword: '',
            newPassword: '',
            confirmPassword: '',
        },

        init() {
            // Load persisted preference state if needed.
        },

        saveSection(section) {
            this.savedSection = section;

            window.setTimeout(() => {
                this.savedSection = '';
            }, 2200);
        },

        saveProfile() {
            this.profileError = '';

            if (this.profile.newPassword && this.profile.newPassword.length < 12) {
                this.profileError = 'New password must be at least twelve characters.';
                return;
            }

            if (this.profile.newPassword !== this.profile.confirmPassword) {
                this.profileError = 'New password and confirmation do not match.';
                return;
            }

            this.savedSection = 'profile';

            window.setTimeout(() => {
                this.savedSection = '';
            }, 2200);
        },

        handleLogoUpload(event) {
            const file = event.target.files[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();

            reader.onload = () => {
                this.logoPreview = reader.result;
            };

            reader.readAsDataURL(file);
        },
    };
}
