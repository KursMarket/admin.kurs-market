<div class="actions">
    <a href="{{ $routeEdit }}" class="btn btn-outline-success"><i class="bi bi-pencil-fill"></i></a>
    <form action="{{ $action }}" method="post">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-primary" onclick="if (!confirm('Вы уверены? Это действие необратимо!')) return false;"><i class="bi bi-trash-fill"></i></button>
    </form>
</div>
