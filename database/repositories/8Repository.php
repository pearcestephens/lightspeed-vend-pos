<?php

namespace App\Repositories;

use App\Models\8;
use Illuminate\Database\Eloquent\Collection;

class 8Repository {

    public function findById($id): ?8 {
        return 8::find($id);
    }

    public function getAll(): Collection {
        return 8::all();
    }

    public function create(array $data): 8 {
        return 8::create($data);
    }

    public function update($id, array $data): bool {
        return 8::find($id)->update($data);
    }

    public function delete($id): bool {
        return 8::destroy($id) > 0;
    }
}