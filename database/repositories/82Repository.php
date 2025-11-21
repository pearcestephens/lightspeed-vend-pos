<?php

namespace App\Repositories;

use App\Models\82;
use Illuminate\Database\Eloquent\Collection;

class 82Repository {

    public function findById($id): ?82 {
        return 82::find($id);
    }

    public function getAll(): Collection {
        return 82::all();
    }

    public function create(array $data): 82 {
        return 82::create($data);
    }

    public function update($id, array $data): bool {
        return 82::find($id)->update($data);
    }

    public function delete($id): bool {
        return 82::destroy($id) > 0;
    }
}