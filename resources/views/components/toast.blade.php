<div id="toast" class="toast-notification">
    <i class='bx bx-check-circle icon'></i>
    <span class="message"></span>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toast = {
        element: document.getElementById('toast'),
        isShowing: false,
        show(message, type = 'success') {
            if (!this.element || !message || this.isShowing) return;

            const messageEl = this.element.querySelector('.message');
            if (messageEl) {
                messageEl.textContent = message;
            }

            this.isShowing = true;
            requestAnimationFrame(() => {
                this.element.classList.add('show', type);

                setTimeout(() => {
                    this.hide();
                }, 3000);
            });
        },
        hide() {
            if (!this.element) return;
            this.element.classList.remove('show', 'success');
            this.isShowing = false;
            sessionStorage.removeItem('toastMessage');
        }
    };

    // Global function to show toast
    window.showToast = function(message) {
        if (message && !toast.isShowing) {
            toast.show(message);
            sessionStorage.removeItem('toastMessage');
        }
    };

    // Global function to store toast message for next page
    window.storeToastMessage = function(message) {
        if (message) {
            sessionStorage.setItem('toastMessage', message);
        }
    };

    // Get navigation type
    const navType = performance.getEntriesByType('navigation')[0]?.type || '';
    const isPageRefresh = navType === 'reload';
    const isBackNavigation = navType === 'back_forward';

    // Only show Laravel flash messages if it's not a refresh or back navigation
    @if(session('success'))
        if (!isPageRefresh && !isBackNavigation) {
            showToast("{{ session('success') }}");
        }
    @endif

    // Only show stored messages if it's a genuine navigation (not refresh or back)
    const storedMessage = sessionStorage.getItem('toastMessage');
    if (storedMessage && !isPageRefresh && !isBackNavigation) {
        showToast(storedMessage);
    }

    // Clear storage in all cases to prevent future unwanted shows
    sessionStorage.removeItem('toastMessage');
});
</script>
