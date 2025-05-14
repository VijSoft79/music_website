<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Additional Information</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- estimated reviews --}}
            <div class="col-12 col-md-6 px-1">
                <label class="col-12 col-form-label">Estimated Visitor on your website</label>
                <select class="form-control" name="estimated_visitor">
                    <option value="">1-100</option>
                    <option value="">101-300</option>
                    <option value="">301-1000</option>
                    <option value="">1000+</option>
                </select>
            </div>

            <!-- total reviews -->
            <div class="col-12 col-md-6">
                <label class=" col-form-label">How many total reviews, articles, new posts, etc do
                    you post per week?</label>
                <input type="number" name="total_reviews" value="{{ old('location', Auth::user()->location) }}"
                    class="form-control" id="inputPassword">
            </div>

            {{-- contribution bio --}}
            <div class="col-12">
                <div class="mb-3 row">
                    <label class="col-12 col-form-label">Tell us in detail what kinds of coverage you can offer to the
                        musicians that will be submitting songs to our platform</label>
                    <div class="col-sm-12">
                        <textarea name="contribution_bio" class="form-control" rows="10" placeholder="Tell us what you can contribute">{{ Auth::user()->contribution_bio }}</textarea>
                    </div>
                </div>
                @error('contribution_bio')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

</div>
