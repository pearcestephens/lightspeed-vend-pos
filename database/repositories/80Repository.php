<?php

namespace App\Repositories;

use App\Models\80;
use Illuminate\Database\Eloquent\Collection;

class 80Repository {

    public function findById($id): ?80 {
        return 80::find($id);
    }

    public function getAll(): Collection {
        return 80::all();
    }

    public function create(array $data): 80 {
        return 80::create($data);
    }

    public function update($id, array $data): bool {
        return 80::find($id)->update($data);
    }

    public function delete($id): bool {
        return 80::destroy($id) > 0;
    }
}