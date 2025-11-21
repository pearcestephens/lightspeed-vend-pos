<?php

namespace App\Repositories;

use App\Models\76;
use Illuminate\Database\Eloquent\Collection;

class 76Repository {

    public function findById($id): ?76 {
        return 76::find($id);
    }

    public function getAll(): Collection {
        return 76::all();
    }

    public function create(array $data): 76 {
        return 76::create($data);
    }

    public function update($id, array $data): bool {
        return 76::find($id)->update($data);
    }

    public function delete($id): bool {
        return 76::destroy($id) > 0;
    }
}