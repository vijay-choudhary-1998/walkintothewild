<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>{{ $pageTitle }} Management</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label class="form-label">Contact Email</label>
                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                        wire:model="contact_email" placeholder="Enter email">
                    @error('contact_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Phone</label>
                    <input type="number" class="form-control @error('contact_phone') is-invalid @enderror"
                        step="1" wire:model="contact_phone" placeholder="Enter phone number">
                    @error('contact_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Address</label>
                    <textarea class="form-control @error('contact_address') is-invalid @enderror" wire:model="contact_address"
                        placeholder="Enter address"></textarea>
                    @error('contact_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Google Map Embed (iframe)</label>
                    <textarea class="form-control @error('contact_map_embed') is-invalid @enderror" wire:model.defer="contact_map_embed"
                        placeholder='<iframe src="https://www.google.com/maps/embed?..."></iframe>' rows="4"></textarea>
                    @error('contact_map_embed')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <hr>
                <h5 class="mt-4">Social Media Links</h5>

                @foreach ([
        'facebook_url' => 'Facebook',
        'instagram_url' => 'Instagram',
        'twitter_url' => 'Twitter',
        'youtube_url' => 'YouTube',
        'linkedin_url' => 'LinkedIn',
    ] as $key => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }} URL</label>
                        <input type="url" class="form-control @error($key) is-invalid @enderror"
                            wire:model.defer="{{ $key }}" placeholder="Enter {{ $label }} link">
                        @error($key)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <button class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Front View</h4>
        </div>
        <div class="card-body d-flex justify-content-between">
            <div>

                <p><strong>Email:</strong> {{ \App\Models\SiteSetting::getValue('contact_email') }}</p>
                <p><strong>Phone:</strong> {{ \App\Models\SiteSetting::getValue('contact_phone') }}</p>
                <p><strong>Address:</strong> {{ \App\Models\SiteSetting::getValue('contact_address') }}</p>
                {!! \App\Models\SiteSetting::getValue('contact_map_embed') !!}
            </div>

            <ul class="nav-links">
                <li class="nav-item"><a href="{{ \App\Models\SiteSetting::getValue('facebook_url') }}" target="_blank">Facebook</a></li>
                <li class="nav-item"><a href="{{ \App\Models\SiteSetting::getValue('instagram_url') }}" target="_blank">Instagram</a></li>
                <li class="nav-item"><a href="{{ \App\Models\SiteSetting::getValue('twitter_url') }}" target="_blank">Twitter</a></li>
                <li class="nav-item"><a href="{{ \App\Models\SiteSetting::getValue('youtube_url') }}" target="_blank">YouTube</a></li>
                <li class="nav-item"><a href="{{ \App\Models\SiteSetting::getValue('linkedin_url') }}" target="_blank">LinkedIn</a></li>
            </ul>

        </div>
    </div>
</div>
