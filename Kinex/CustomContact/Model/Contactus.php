<?php
namespace Kinex\CustomContact\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Contactus extends AbstractModel 
{
	const CACHE_TAG = 'contact_us';
	const ID = 'entity_id';
	const NAME = 'name';
	const EMAIL = 'email';
	const TELEPHONE = 'telephone';
	const SUBJECT = 'subject';
	const COMMENT = 'comment';

	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;
	
	protected function _construct()
    {
        $this->_init('Kinex\CustomContact\Model\ResourceModel\Contactus');
    }
	
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
    
    public function setId($id)
	{
		return $this->setData(self::ID, $id);
	}

	public function setName($name)
	{
		return $this->setData(self::NAME, $name);
	}

	public function setEmail($email)
	{
		return $this->setData(self::EMAIL, $email);
	}

	public function setTelephone($telephone)
	{
		return $this->setData(self::TELEPHONE, $telephone);
	}

	public function setSubject($subject)
	{
		return $this->setData(self::SUBJECT, $subject);
	}

	public function setComments($comment)
	{
		return $this->setData(self::COMMENT, $comment);
	}

	public function getId()
	{
		return parent::getData(self::ID);
	}

	public function getName()
	{
		return $this->getData(self::NAME);
	}

	public function getEmail()
	{
		return $this->getData(self::EMAIL);
	}

	public function getPhoneNumber()
	{
		return $this->getData(self::TELEPHONE);
	}

	public function getSubject()
	{
		return $this->getData(self::SUBJECT);
	}

	public function getComments()
	{
		return $this->getData(self::COMMENT);
	}
}
?>