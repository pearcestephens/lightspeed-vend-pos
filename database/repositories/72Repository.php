<?php

namespace App\Repositories;

use App\Models\72;
use Illuminate\Database\Eloquent\Collection;

class 72Repository {

    public function findById($id): ?72 {
        return 72::find($id);
    }

    public function getAll(): Collection {
        return 72::all();
    }

    public function create(array $data): 72 {
        return 72::create($data);
    }

    public function update($id, array $data): bool {
        return 72::find($id)->update($data);
    }

    public function delete($id): bool {
        return 72::destroy($id) > 0;
    }
}