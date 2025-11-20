<?php

namespace App\Repositories;

use App\Models\6;
use Illuminate\Database\Eloquent\Collection;

class 6Repository {

    public function findById($id): ?6 {
        return 6::find($id);
    }

    public function getAll(): Collection {
        return 6::all();
    }

    public function create(array $data): 6 {
        return 6::create($data);
    }

    public function update($id, array $data): bool {
        return 6::find($id)->update($data);
    }

    public function delete($id): bool {
        return 6::destroy($id) > 0;
    }
}