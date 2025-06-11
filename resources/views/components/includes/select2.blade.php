<script data-navigate-once>
    function select2Initialize() {
        $('select.select2').each(function() {
            const $this = $(this);
            const selectId = $this.attr('id');
            const placeholder = $this.attr('placeholder') || 'Select an option';

            // Prevent double init
            if ($this.hasClass('select2-initialized')) return;

            $this.select2({
                    placeholder
                })
                .on('change', function() {
                    const value = $(this).val();
                    const component = Livewire.first();
                    if (component) {
                        component.set(selectId, value);
                    }
                });

            $this.addClass('select2-initialized');
        });
    }

    document.addEventListener('livewire:init', select2Initialize);

    document.addEventListener('livewire:navigated', select2Initialize);

    Livewire.hook('morphed', () => {
        select2Initialize();
    });
</script>
