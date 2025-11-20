<?php

namespace App\Repositories;

use App\Models\12;
use Illuminate\Database\Eloquent\Collection;

class 12Repository {

    public function findById($id): ?12 {
        return 12::find($id);
    }

    public function getAll(): Collection {
        return 12::all();
    }

    public function create(array $data): 12 {
        return 12::create($data);
    }

    public function update($id, array $data): bool {
        return 12::find($id)->update($data);
    }

    public function delete($id): bool {
        return 12::destroy($id) > 0;
    }
}