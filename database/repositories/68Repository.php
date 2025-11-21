<?php

namespace App\Repositories;

use App\Models\68;
use Illuminate\Database\Eloquent\Collection;

class 68Repository {

    public function findById($id): ?68 {
        return 68::find($id);
    }

    public function getAll(): Collection {
        return 68::all();
    }

    public function create(array $data): 68 {
        return 68::create($data);
    }

    public function update($id, array $data): bool {
        return 68::find($id)->update($data);
    }

    public function delete($id): bool {
        return 68::destroy($id) > 0;
    }
}