<?php
namespace App\Http\Requests\Auth\CallCenter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
class CallCenterLoginRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate($request) {
        $this->ensureIsNotRateLimited();
        if (auth('call-center')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            $this->recordAttendance(auth('call-center')->user(), 'login');
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);

        }
        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5))
            return;
        event(new Lockout($this));
        $seconds = RateLimiter::availableIn($this->throttleKey());
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function recordAttendance($user, $action) {
        $user->call_center_attendances()->create([
            'call_center_id' => $user->id,
            'day' => now()->toDateString(),
            $action => now()->format('H:i:s'),
        ]);
    }

    public function throttleKey(): string {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}