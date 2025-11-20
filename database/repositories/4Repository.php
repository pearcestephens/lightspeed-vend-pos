<?php

namespace App\Repositories;

use App\Models\4;
use Illuminate\Database\Eloquent\Collection;

class 4Repository {

    public function findById($id): ?4 {
        return 4::find($id);
    }

    public function getAll(): Collection {
        return 4::all();
    }

    public function create(array $data): 4 {
        return 4::create($data);
    }

    public function update($id, array $data): bool {
        return 4::find($id)->update($data);
    }

    public function delete($id): bool {
        return 4::destroy($id) > 0;
    }
}