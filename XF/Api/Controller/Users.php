<?php

namespace Verringer\APIUsergroupList\XF\Api\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

class Users extends XFCP_Users
{

	/**
	 * @api-desc Finds a single user based on matching criteria
	 *
	 * @api-in int $group
	 */

	public function actionGetGroup(ParameterBag $params)
	{

		// Group ID
		if ($this->filter('id', 'int')) {
			$group = $this->filter('id', 'int');
		}

		// Groups STR CSL
		elseif($this->filter('ids', 'str')) {
			$groups = $this->filter('ids', 'str');
		}

		$finder = $this->finder('XF:User');

		$user = null;

		if(isset($group)) {
			$column = $finder->columnSqlName('secondary_group_ids');
			
			$user = $finder->with('api')->whereSql("FIND_IN_SET(". $group .", ". $finder->columnSqlName('secondary_group_ids').") OR ". $finder->columnSqlName('user_group_id'). " = ". $group ."");

			$users = array();

			foreach($user as $user) {
				$users [] = $user;
			}
		}

		if(isset($groups)) {
			$groups_arr = array_unique(explode(',', $groups));
			$users = array();
			$x = 0;
			foreach($groups_arr as $value) {
				$finder = \XF::finder('XF:User');
				$user = $finder->whereSql("FIND_IN_SET(". $value .", ". $finder->columnSqlName('secondary_group_ids').") OR ". $finder->columnSqlName('user_group_id'). " = ". $value ."");
				$users_arr = $user->fetch();
				$users[$x]['usergroup_id'] = $value;
				foreach ($users_arr as $key => $user)
				{
					$users[$x][] = $user;
				}
				$x++;
			}
		}

		if (!$user)
		{
			throw $this->exception(
				$this->notFound(\XF::phrase('requested_page_not_found'))
			);
		}

		$result = $users;

		return $this->apiResult($result);
	}
}