<div class="card">
    <div class="card-header">
        <h3 class="card-title">Email Preferences</h3>
    </div>
    <div class="card-body">
        <p>You can choose to receive or opt-out of non-critical emails from us.</p>
        <p class="mb-4">Critical emails such as password resets and security notifications will still be sent.</p>
        
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="emailToggle" name="receive_emails" {{ Auth::user()->wantsToReceiveEmails() ? 'checked' : '' }}>
                <label class="custom-control-label" for="emailToggle">
                    <strong>{{ Auth::user()->wantsToReceiveEmails() ? 'Email notifications are ON' : 'Email notifications are OFF' }}</strong>
                </label>
            </div>
            <small class="form-text text-muted">
                {{ Auth::user()->wantsToReceiveEmails() 
                    ? 'You will receive emails about offers, updates, and other information.' 
                    : 'You will not receive non-critical emails from us.' }}
            </small>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('emailToggle').addEventListener('change', function() {
    const formData = new FormData();
    formData.append('receive_emails', this.checked ? '1' : '0');
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route('email.preferences.toggle') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the label text
            const label = this.nextElementSibling;
            label.innerHTML = `<strong>Email notifications are ${this.checked ? 'ON' : 'OFF'}</strong>`;
            
            // Update the description text
            const description = this.parentElement.nextElementSibling;
            description.textContent = this.checked 
                ? 'You will receive emails about offers, updates, and other information.'
                : 'You will not receive non-critical emails from us.';

            showToast('success', data.message);
        } else {
            // Revert the toggle if the request failed
            this.checked = !this.checked;
            showToast('danger', data.message);
        }
    })
    .catch(error => {
        // Revert the toggle if there was an error
        this.checked = !this.checked;
        
        // Show error toast
        showToast('danger', 'An error occurred while updating your preferences.');
    });
});

function showToast(type, message) {
    // Create toast container if it doesn't exist
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.style.position = 'fixed';
    toast.style.top = '1rem';
    toast.style.right = '1rem';

    // Create toast content
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

    // Add toast to container
    container.appendChild(toast);

    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
    });
    bsToast.show();

    // Remove toast from DOM after it's hidden
    toast.addEventListener('hidden.bs.toast', function () {
        toast.remove();
    });
}
</script>
@endpush 