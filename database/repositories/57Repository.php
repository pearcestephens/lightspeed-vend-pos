<?php

namespace App\Repositories;

use App\Models\57;
use Illuminate\Database\Eloquent\Collection;

class 57Repository {

    public function findById($id): ?57 {
        return 57::find($id);
    }

    public function getAll(): Collection {
        return 57::all();
    }

    public function create(array $data): 57 {
        return 57::create($data);
    }

    public function update($id, array $data): bool {
        return 57::find($id)->update($data);
    }

    public function delete($id): bool {
        return 57::destroy($id) > 0;
    }
}