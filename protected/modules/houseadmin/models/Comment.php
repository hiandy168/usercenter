<?php
/*
评论类

可以添加 删除 查看评论
*/
class Projectcomment extends BaseDBModel
{
	const TABLE_NAME = 'wh_comment';

	/**
	 * Comment::insert()
	 * 新增评论
	 *
	 * @param mixed $comment 评论数组，包含评论者QQ号昵称、评论内容、评论时间、被评论微信ID
	 * @return  返回操作结果,成功返回true,失败返回false
	 */
	public function insertComment($comment)
	{
		if(count($comment) != 5 || empty($comment['wxid']) || empty($comment['nickname']) || empty($comment['content']) || empty($comment['uid'])
			|| empty($comment['createtime']) )
		{
			return false;
		}

		$insert['table'] = self::TABLE_NAME;//插入表的名称
		$insert['values'] = $comment;    //插入的数据
		if( parent::Insert($insert) != 0 )
		{
			return true;
		}
		else
		{
			return false;
		}


	}

	/**
	 * Comment::deleteComment()
	 *	删除评论
	 *
	 * @param mixed $id 评论id号
	 * @return 返回操作结果,成功返回true,失败返回false
	 */
	public function deleteComment($id)
	{
		if( empty($id) || !is_numeric($id))
		{
			return false;
		}

		$delete['table'] = self::TABLE_NAME;
		$delete['where'] = 'id="'.$id.'"';
		return parent::Delete($delete);
	}

	public function queryComment($key, $value)
	{
		if( empty($key) || empty($value) )
		{
			return false;
		}

		$select['table'] = self::TABLE_NAME;
		if($key != "content")
		{
			$select['where'] = $key.'="'.$value.'"';
		}
		else
		{
			$select['where'] = 'content like "%'.$value.'%"';
		}

		$select['select'] = 'id, wxid, uid, nickname, content, createtime, reply';

		return parent::Query($select,self::QUERYLIST);
	}



}

?>