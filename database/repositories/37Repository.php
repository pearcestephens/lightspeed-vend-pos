<?php

namespace App\Repositories;

use App\Models\37;
use Illuminate\Database\Eloquent\Collection;

class 37Repository {

    public function findById($id): ?37 {
        return 37::find($id);
    }

    public function getAll(): Collection {
        return 37::all();
    }

    public function create(array $data): 37 {
        return 37::create($data);
    }

    public function update($id, array $data): bool {
        return 37::find($id)->update($data);
    }

    public function delete($id): bool {
        return 37::destroy($id) > 0;
    }
}