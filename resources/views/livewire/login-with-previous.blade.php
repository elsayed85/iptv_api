<div>
    @if (session()->has('error'))
        <div class="alert alert-danger" style="color: red;background:white;padding : 10px;">
            {{ session('error') }}
        </div>
    @endif
    @foreach ($users as $user)
        <h2>
            <button wire:click="login('{{ $user['portal'] }}', '{{ $user['username'] }}')"
                style="background:black;padding:10px;border-radius:10px;cursor:pointer;border:none;color:white;font-size:20px;">
                {{ $user['portal'] . '  |  ' . $user['username'] }}
            </button>
        </h2>
    @endforeach
</div>
