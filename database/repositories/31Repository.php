<?php

namespace App\Repositories;

use App\Models\31;
use Illuminate\Database\Eloquent\Collection;

class 31Repository {

    public function findById($id): ?31 {
        return 31::find($id);
    }

    public function getAll(): Collection {
        return 31::all();
    }

    public function create(array $data): 31 {
        return 31::create($data);
    }

    public function update($id, array $data): bool {
        return 31::find($id)->update($data);
    }

    public function delete($id): bool {
        return 31::destroy($id) > 0;
    }
}