<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="row">
            <div class="col-2">
                Additional information
            </div>
        </div>
    </div>

    <div class="card-body">
        <p>The following fields are optional but should be included to expedite approval. These fields will not be shown on your public facing profile.</p>
        <div class="row">
            {{-- estimated reviews --}}
            <div class="col-12 col-md-6 px-1">
                <label class="col-12 col-form-label">Estimated Visitor on your website</label>
                <select class="form-control" name="estimated_visitor">
                    <option value="1-100" {{ old('estimated_visitor') == '1-100' ? 'selected' : '' }}>1-100</option>
                    <option value="101-300" {{ old('estimated_visitor') == '101-300' ? 'selected' : '' }}>101-300</option>
                    <option value="301-1000" {{ old('estimated_visitor') == '301-1000' ? 'selected' : '' }}>301-1000</option>
                    <option value="1000+" {{ old('estimated_visitor') == '1000+' ? 'selected' : '' }}>1000+</option>
                </select>
            </div>

            <!-- total reviews -->
            <div class="col-12 col-md-6">
                <label class=" col-form-label">How many total reviews, articles, new posts, etc do
                    you post per week?</label>
                <input type="number" name="total_reviews" value="{{ old('location', Auth::user()->total_reviews) }}"
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
