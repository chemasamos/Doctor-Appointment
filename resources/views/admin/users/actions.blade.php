<div class="flex items-center space-x-2">
    <x-wire-button href="{{ route('admin.users.edit', $user) }}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    @if($user->id !== auth()->id())
        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-wire-button type="button" red xs onclick="confirmDelete('delete-form-{{ $user->id }}')">
                <i class="fa-solid fa-trash"></i>
            </x-wire-button>
        </form>
    @endif
</div>