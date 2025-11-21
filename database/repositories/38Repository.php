<?php

namespace App\Repositories;

use App\Models\38;
use Illuminate\Database\Eloquent\Collection;

class 38Repository {

    public function findById($id): ?38 {
        return 38::find($id);
    }

    public function getAll(): Collection {
        return 38::all();
    }

    public function create(array $data): 38 {
        return 38::create($data);
    }

    public function update($id, array $data): bool {
        return 38::find($id)->update($data);
    }

    public function delete($id): bool {
        return 38::destroy($id) > 0;
    }
}