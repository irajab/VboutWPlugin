<?php

require_once dirname(dirname(__FILE__)) . '/base/Vbout.php';
require_once dirname(dirname(__FILE__)) . '/base/VboutException.php';

class EmailMarketingWS extends Vbout 
{
	protected function init()
	{
		$this->api_url = '/emailmarketing/';
	}
	
	public function getCampaigns($params = array())
    {	
		$result = array();
		
		try {
			$campaigns = $this->campaigns($params);

            if ($campaigns != null && isset($campaigns['data'])) {
                $result = array_merge($result, $campaigns['data']['campaigns']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function getCampaign($params = array())
    {	
		$result = array();
		
		try {
			$campaign = $this->getcampaign($params);

            if ($campaign != null && isset($campaign['data'])) {
                $result = array_merge($result, $campaign['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function deleteCampaign($params = array())
    {	
		$result = array();
		
		try {
			$campaign = $this->deletecampaign($params);

            if ($campaign != null && isset($campaign['data'])) {
                $result = array_merge($result, $campaign['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function addCampaign($params = array())
    {	
		$result = array();
		
		try {
			$campaign = $this->addcampaign($params);

            if ($campaign != null && isset($campaign['data'])) {
                $result = array_merge($result, $campaign['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function editCampaign($params = array())
    {	
		$result = array();
		
		try {
			$campaign = $this->editcampaign($params);

            if ($campaign != null && isset($campaign['data'])) {
                $result = array_merge($result, $campaign['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function getLists()
    {	
		$result = array();
		
		try {
			$lists = $this->getlists();

            if ($lists != null && isset($lists['data'])) {
                $result = array_merge($result, $lists['data']['lists']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function getList($id = NULL)
    {	
		$result = array();
		
		try {
			$list = $this->getlist(array('id'=>$id));

            if ($list != null && isset($list['data'])) {
                $result = array_merge($result, $list['data']['list']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function addList($params = array())
    {	
		$result = array();
		
		try {
			$list = $this->addlist($params);

            if ($list != null && isset($list['data'])) {
                $result = array_merge($result, $list['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function deleteList($id = NULL)
    {	
		$result = array();
		
		try {
			$list = $this->deletelist(array('id'=>$id));

            if ($list != null && isset($list['data'])) {
                $result = array_merge($result, $list['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function editList($params = array())
    {	
		$result = array();
		
		try {
			$list = $this->editlist($params);

            if ($list != null && isset($list['data'])) {
                $result = array_merge($result, $list['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function getContacts($listId = NULL)
    {	
		$result = array();
		
		try {
			$contacts = $this->getcontacts(array('listid'=>$listId));

            if ($contacts != null && isset($contacts['data'])) {
                $result = array_merge($result, $contacts['data']['contacts']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function getContact($id = NULL)
    {	
		$result = array();
		
		try {
			$contact = $this->getcontact(array('id'=>$id));

            if ($contact != null && isset($contact['data'])) {
                $result = array_merge($result, $contact['data']['contact']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function addContact($params = array())
    {	
		$result = array();
		
		try {
			$contact = $this->addcontact($params);

            if ($contact != null && isset($contact['data'])) {
                $result = array_merge($result, $contact['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function editContact($params = array())
    {	
		$result = array();
		
		try {
			$contact = $this->editcontact($params);

            if ($contact != null && isset($contact['data'])) {
                $result = array_merge($result, $contact['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function deleteContact($id = NULL)
    {	
		$result = array();
		
		try {
			$contact = $this->deletecontact(array('id'=>$id));

            if ($contact != null && isset($contact['data'])) {
                $result = array_merge($result, $contact['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
	
	public function getStats($params = array())
    {	
		$result = array();
		
		try {
			$stats = $this->stats($params);

            if ($stats != null && isset($stats['data'])) {
                $result = array_merge($result, $stats['data']['item']);
            }

		} catch (VboutException $ex) {
			$result = $ex->getData();
        }
		
       return $result;
    }
}