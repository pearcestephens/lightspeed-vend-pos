<?php

namespace App\Repositories;

use App\Models\16;
use Illuminate\Database\Eloquent\Collection;

class 16Repository {

    public function findById($id): ?16 {
        return 16::find($id);
    }

    public function getAll(): Collection {
        return 16::all();
    }

    public function create(array $data): 16 {
        return 16::create($data);
    }

    public function update($id, array $data): bool {
        return 16::find($id)->update($data);
    }

    public function delete($id): bool {
        return 16::destroy($id) > 0;
    }
}