<table class="border-collapse border border-slate-400 mb-1">
    <thead class="bg-slate-50">
        <tr class="*:border *:border-slate-300 *:p-4 *:font-semibold *:text-left">
            @foreach ($columns as $key => $column)
                @if ($key == 'no')
                    <th>{{ $column['header'] ?? 'No' }}</th>
                @elseif ($key !== 'action')
                    <th>{{ $column }}</th>
                @elseif($key == 'action')
                    <th>{{ $column['header'] ?? 'Action' }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if (count($collections) > 0)
            @foreach ($collections as $item)
                <tr class="*:border *:border-slate-300 *:p-4 *:text-slate-500 *:hover:text-black">
                    @foreach ($columns as $key => $column)
                        @if ($key == 'no')
                            <td>{{ 1 + $loop->parent->index }}</td>
                        @elseif ($key !== 'action')
                            <td>{{ $item->{$key} }}</td>
                        @elseif($key == 'action')
                            <td>
                                @if (!empty($column['view']) && $column['view'])
                                    <a href=""
                                        class="mx-1 p-2 hover:shadow-lg bg-indigo-400 text-white rounded hover:cursor-default">
                                        View
                                    </a>
                                @endif
                                @if (!empty($column['edit']) && $column['edit'])
                                    <a wire:navigate href="{{ $item->editUrl() }}"
                                        class="mx-1 p-2 hover:shadow-lg bg-yellow-400 text-white rounded hover:cursor-default">
                                        Edit
                                    </a>
                                @endif
                                @if (!empty($column['delete']) && $column['delete'])
                                    <a href="" class="mx-1 p-2 hover:shadow-lg bg-green-400 text-white rounded">
                                        Delete
                                    </a>
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        @else
            <tr>
                <td>
                    No Data
                </td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr class="*:border *:border-slate-300 *:p-4 *:font-semibold *:text-left">
            @foreach ($columns as $key => $column)
                @if ($key == 'no')
                    <th>{{ $column['header'] ?? 'No' }}</th>
                @elseif ($key !== 'action')
                    <th>{{ $column }}</th>
                @elseif($key == 'action')
                    <th>{{ $column['header'] ?? 'Action' }}</th>
                @endif
            @endforeach
        </tr>
    </tfoot>
</table>
@if (!empty($pagination) && $pagination === true)
    <div>
        {{ $collections->links() }}
    </div>
@endif
