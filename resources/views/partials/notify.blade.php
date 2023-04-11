<div
    x-data="{
        notifications: [],
        add(e) {
            this.notifications.push({ id: e.timeStamp, type: e.detail.type, content: e.detail.content })
        },
        remove(notification) {
            this.notifications = this.notifications.filter(i => i.id !== notification.id)
        }
    }"
    @notify.window="add($event)"
    class="fixed bottom-0 right-0 flex flex-col w-full max-w-xs pb-4 pr-4 space-y-4 sm:justify-start"
    role="status"
    aria-live="polite"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div
            x-data="{
                show: true,
                transitionOut() {
                    this.show = false
                    setTimeout(() => this.remove(this.notification), 500)
                }
            }"
            x-init="
                $nextTick(() => show = true)
                setTimeout(() => transitionOut(), 5000)
            "
            x-show="show"
            x-transition.duration.500ms
            class="relative w-full max-w-sm py-4 px-4 bg-white border border-gray-200 rounded-md shadow-lg pointer-events-auto"
        >
            <div class="flex items-start">
                <div x-show="notification.type === 'info'" class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <span class="sr-only">{{ __('Information:') }}</span>
                </div>
                <div x-show="notification.type === 'success'" class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="sr-only">{{ __('Success:') }}</span>
                </div>
                <div x-show="notification.type === 'error'" class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span class="sr-only">{{ __('Error:') }}</span>
                </div>

                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p x-text="notification.content" class="text-sm font-medium leading-5 text-gray-900"></p>
                </div>

                <div class="flex flex-shrink-0 ml-4">
                    <button @click="transitionOut()" type="button" class="inline-flex text-gray-400">
                        <svg aria-hidden class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">{{ __('Close notification') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

