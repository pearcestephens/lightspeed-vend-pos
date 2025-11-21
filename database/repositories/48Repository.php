<?php

namespace App\Repositories;

use App\Models\48;
use Illuminate\Database\Eloquent\Collection;

class 48Repository {

    public function findById($id): ?48 {
        return 48::find($id);
    }

    public function getAll(): Collection {
        return 48::all();
    }

    public function create(array $data): 48 {
        return 48::create($data);
    }

    public function update($id, array $data): bool {
        return 48::find($id)->update($data);
    }

    public function delete($id): bool {
        return 48::destroy($id) > 0;
    }
}