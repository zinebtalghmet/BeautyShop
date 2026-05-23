<div class="relative" x-data="{
    dropdownOpen: false,
    unreadCount: 0,
    notifications: [],
    init() {
        this.fetchNotifications();
        setInterval(() => this.fetchNotifications(), 30000);
    },
    fetchNotifications() {
        fetch('/admin/notifications/fetch')
            .then(r => r.json())
            .then(data => {
                this.unreadCount = data.unread_count;
                this.notifications = data.notifications;
            })
            .catch(() => {});
    },
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
        if (this.dropdownOpen) {
            this.markAllSeen();
        }
    },
    closeDropdown() {
        this.dropdownOpen = false;
    },
    markAllSeen() {
        fetch('/admin/notifications/read-all', { method: 'PUT', headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' } })
            .then(() => { this.unreadCount = 0; })
            .catch(() => {});
    },
    markRead(id, link) {
        fetch(`/admin/notifications/${id}/read`, { method: 'PUT', headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' } })
            .then(() => {
                const n = this.notifications.find(n => n.id === id);
                if (n) n.is_read = true;
                this.unreadCount = Math.max(0, this.unreadCount - 1);
            })
            .catch(() => {});
        if (link) window.location.href = link;
    }
}" @click.away="closeDropdown()">
    <button class="relative flex items-center justify-center text-gray-500 transition-colors bg-white border border-gray-200 rounded-full hover:text-dark-900 h-11 w-11 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white" @click="toggleDropdown()" type="button">
        <span x-show="unreadCount > 0" class="absolute right-0 top-0.5 z-1 h-2 w-2 rounded-full bg-orange-400">
            <span class="absolute inline-flex w-full h-full bg-orange-400 rounded-full opacity-75 -z-1 animate-ping"></span>
        </span>
        <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-1 -right-1 z-1 min-w-[18px] h-[18px] flex items-center justify-center rounded-full bg-error-500 text-white text-[10px] font-bold px-1"></span>
        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z" fill="currentColor"/></svg>
    </button>

    <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute -right-[10px] mt-[17px] flex w-[360px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark z-50" style="display: none;">
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 dark:border-gray-700">
            <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-400">
                Notifications
                <span x-show="unreadCount > 0" x-text="`(${unreadCount})`" class="text-sm text-gray-400 font-normal"></span>
            </h5>
            <button @click="closeDropdown()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.8913 9.99599L15.7354 6.15182C16.0892 5.79804 16.0892 5.22788 15.7354 4.8741C15.3817 4.52033 14.8115 4.52033 14.4577 4.8741L10.6135 8.71827L6.76937 4.8741C6.41559 4.52033 5.84544 4.52033 5.49166 4.8741C5.13788 5.22788 5.13788 5.79804 5.49166 6.15182L9.33583 9.99599L5.49166 13.8402C5.13788 14.1939 5.13788 14.7641 5.49166 15.1179C5.84544 15.4717 6.41559 15.4717 6.76937 15.1179L10.6135 11.2737L14.4577 15.1179C14.8115 15.4717 15.3817 15.4717 15.7354 15.1179C16.0892 14.7641 16.0892 14.1939 15.7354 13.8402L11.8913 9.99599Z" fill="currentColor"/></svg>
            </button>
        </div>

        <ul class="flex flex-col gap-1 max-h-[320px] overflow-y-auto">
            <template x-for="n in notifications" :key="n.id">
                <li>
                    <a href="#"
                       @click.prevent="markRead(n.id, n.link)"
                       class="flex gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5"
                       :class="{ 'bg-gray-50 dark:bg-white/[0.03]': !n.is_read }">
                        <span class="block w-full">
                            <span class="block font-medium text-theme-sm" :class="n.is_read ? 'text-gray-600 dark:text-gray-400' : 'text-gray-800 dark:text-white/90'" x-text="n.title"></span>
                            <span x-show="n.message" class="block text-theme-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="n.message"></span>
                            <span class="block text-theme-xs text-gray-400 mt-0.5" x-text="new Date(n.created_at).toLocaleString()"></span>
                        </span>
                    </a>
                </li>
            </template>
            <li x-show="notifications.length === 0" class="px-3 py-6 text-center text-theme-sm text-gray-400">No notifications yet.</li>
        </ul>

        <a href="<?php echo e(route('admin.notifications.index')); ?>" @click.prevent="closeDropdown()"
           class="block px-4 py-3 mt-3 text-sm font-medium text-center text-brand-500 bg-gray-50 rounded-lg hover:bg-gray-100 dark:bg-white/5 dark:hover:bg-white/10">
            View All Notifications
        </a>
    </div>
</div>
<?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/components/header/notification-dropdown.blade.php ENDPATH**/ ?>