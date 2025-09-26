@props(['id', 'title', 'size' => 'md'])

@php
$sizeClasses = [
    'sm' => 'max-w-md',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
    'full' => 'max-w-full mx-4'
];
@endphp

<div id="{{ $id }}" class="modal fixed inset-0 z-50 hidden" x-data="{ open: false }" x-show="open" @click.away="open = false">
    <!-- Backdrop -->
    <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="open = false"></div>

    <!-- Modal Content -->
    <div class="modal-content fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full {{ $sizeClasses[$size] }} bg-white rounded-lg shadow-2xl transition-all duration-300">
        <!-- Header -->
        <div class="modal-header flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="modal-title text-lg font-semibold text-gray-900">{{ $title }}</h3>
            <button type="button" class="modal-close text-gray-400 hover:text-gray-600 transition-colors" @click="open = false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="modal-body p-6">
            {{ $slot }}
        </div>

        <!-- Footer -->
        @if(isset($footer))
        <div class="modal-footer flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
            {{ $footer }}
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const modalInstance = Alpine.store('modal');
            if (modalInstance) {
                modalInstance.open = true;
            } else {
                // Fallback for non-Alpine modals
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const modalInstance = Alpine.store('modal');
            if (modalInstance) {
                modalInstance.open = false;
            } else {
                // Fallback for non-Alpine modals
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
    };

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModals = document.querySelectorAll('.modal:not(.hidden)');
            openModals.forEach(modal => {
                const modalId = modal.id;
                closeModal(modalId);
            });
        }
    });
});
</script>

<style>
.modal {
    backdrop-filter: blur(4px);
}

.modal-content {
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}

.modal-backdrop {
    animation: backdropFadeIn 0.3s ease-out;
}

@keyframes backdropFadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
