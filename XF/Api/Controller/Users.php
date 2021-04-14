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

		$group = $this->filter('id', 'int');

		/** @var \XF\Finder\User $finder */
		$finder = $this->finder('XF:User');

		$user = null;

		// Prep to add $groups in the future via CSL
		if(isset($group)) {
			$column = $finder->columnSqlName('secondary_group_ids');

			$user = $finder->with('api')->whereSql("FIND_IN_SET(". $group .", ". $finder->columnSqlName('secondary_group_ids').") OR ". $finder->columnSqlName('user_group_id'). " = ". $group ."");

			$users = array();

			foreach($user as $user) {
				$users [] = $user;
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