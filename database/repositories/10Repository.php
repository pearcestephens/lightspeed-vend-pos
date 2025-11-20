<?php

namespace App\Repositories;

use App\Models\10;
use Illuminate\Database\Eloquent\Collection;

class 10Repository {

    public function findById($id): ?10 {
        return 10::find($id);
    }

    public function getAll(): Collection {
        return 10::all();
    }

    public function create(array $data): 10 {
        return 10::create($data);
    }

    public function update($id, array $data): bool {
        return 10::find($id)->update($data);
    }

    public function delete($id): bool {
        return 10::destroy($id) > 0;
    }
}