<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        Delete Account
    </div>
    <div class="card-body">
        <p class="text-muted">Once your account is deleted, all of its resources and data will be permanently deleted. 
        Please enter your password to confirm you want to permanently delete your account.</p>

        <form method="POST" action="{{ route('user.Customer.profile-account.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" 
                       class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                       required>
                @error('password', 'userDeletion')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
    </div>
</div>
