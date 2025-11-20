<?php

namespace App\Repositories;

use App\Models\24;
use Illuminate\Database\Eloquent\Collection;

class 24Repository {

    public function findById($id): ?24 {
        return 24::find($id);
    }

    public function getAll(): Collection {
        return 24::all();
    }

    public function create(array $data): 24 {
        return 24::create($data);
    }

    public function update($id, array $data): bool {
        return 24::find($id)->update($data);
    }

    public function delete($id): bool {
        return 24::destroy($id) > 0;
    }
}