    <div class="pt-5">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>First Name</th>
                    <th>Initial</th>
                    <th>Last Name</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @if($persons->total())
                    @foreach($persons as $person)
                        <tr>
                            <td>{{ $person->id }}</td>
                            <td>{{ $person->title }}</td>
                            <td>{{ $person->first_name }}</td>
                            <td>{{ $person->initial }}</td>
                            <td>{{ $person->last_name }}</td>
                            <td>{{ $person->created_at }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">
                            No records in this table.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if($persons->total() > 1)
            <div class="pt-4 text-center custom-pagination">
                {{ $persons->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
