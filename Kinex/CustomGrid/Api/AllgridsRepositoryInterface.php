<?php
namespace Kinex\CustomGrid\Api;

interface AllgridsRepositoryInterface
{
	public function save(\Kinex\CustomGrid\Api\Data\AllgridsInterface $grids);

    public function getById($gridId);

    public function delete(\Kinex\CustomGrid\Api\Data\AllgridsInterface $grids);

    public function deleteById($gridId);
}
?>