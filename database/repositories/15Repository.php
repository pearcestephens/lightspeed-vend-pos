<?php

namespace App\Repositories;

use App\Models\15;
use Illuminate\Database\Eloquent\Collection;

class 15Repository {

    public function findById($id): ?15 {
        return 15::find($id);
    }

    public function getAll(): Collection {
        return 15::all();
    }

    public function create(array $data): 15 {
        return 15::create($data);
    }

    public function update($id, array $data): bool {
        return 15::find($id)->update($data);
    }

    public function delete($id): bool {
        return 15::destroy($id) > 0;
    }
}