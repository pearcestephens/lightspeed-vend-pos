<?php

namespace App\Repositories;

use App\Models\67;
use Illuminate\Database\Eloquent\Collection;

class 67Repository {

    public function findById($id): ?67 {
        return 67::find($id);
    }

    public function getAll(): Collection {
        return 67::all();
    }

    public function create(array $data): 67 {
        return 67::create($data);
    }

    public function update($id, array $data): bool {
        return 67::find($id)->update($data);
    }

    public function delete($id): bool {
        return 67::destroy($id) > 0;
    }
}