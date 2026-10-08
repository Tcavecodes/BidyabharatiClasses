        </div> <!-- End of content padding -->
    </main>
</div>

<!-- Global Admin File Upload Validation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all file inputs in admin portal
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        // Set default hint if not already present
        const defaultMaxSizeMB = input.dataset.maxSizeMb || (input.name === 'doc_file' ? 5 : 2);
        const maxSizeBytes = defaultMaxSizeMB * 1024 * 1024;
        
        // Find existing helper text or insert one
        let parent = input.closest('div') || input.parentElement;
        if (parent && !parent.querySelector('.file-upload-hint')) {
            const hint = document.createElement('p');
            hint.className = 'file-upload-hint text-xs text-slate-400 mt-1 flex items-center gap-1.5';
            hint.innerHTML = `<i class="fa-solid fa-circle-info text-indigo-400"></i> Max allowed size: <strong>${defaultMaxSizeMB} MB</strong>`;
            parent.appendChild(hint);
        }

        // Change listener for instant validation
        input.addEventListener('change', function() {
            const file = this.files[0];
            let errorContainer = parent.querySelector('.file-upload-error');
            
            // Remove previous error container if any
            if (errorContainer) {
                errorContainer.remove();
            }
            this.classList.remove('border-rose-500', 'ring-2', 'ring-rose-500');

            if (!file) return;

            // Check size
            if (file.size > maxSizeBytes) {
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                
                // Reset file input
                this.value = '';

                // Create error banner
                errorContainer = document.createElement('div');
                errorContainer.className = 'file-upload-error mt-2 p-3 rounded-lg bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs flex items-center justify-between gap-2';
                errorContainer.innerHTML = `
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation shrink-0 text-sm"></i>
                        <span>File size (<strong>${fileSizeMB} MB</strong>) exceeds the maximum limit of <strong>${defaultMaxSizeMB} MB</strong>. Please select a smaller file.</span>
                    </div>
                    <button type="button" class="text-rose-400 hover:text-white" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
                `;
                
                parent.appendChild(errorContainer);
                this.classList.add('border-rose-500', 'ring-2', 'ring-rose-500');
            }
        });
    });
});
</script>
</body>
</html>

