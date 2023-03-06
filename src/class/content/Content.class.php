<?php

namespace content;

/**
 * A content in a specific language
 */
class Content extends \core\Managed
{
	use \core\Base
	{
		\core\Base::display as display_;
	}
	/**
	 * Content ID (not unique)
	 *
	 * @var int
	 */
	protected ?int $id_content = null;
	/** Code corresponding to a language ()
	 *
	 * @var string
	 **/
	protected ?string $lang = null;
	/**
	 * Content (which is found with the id_content and the lang, or defined without)
	 *
	 * @var string
	 */
	protected ?string $text = null;
	/**
	 * Date of the content creation
	 *
	 * @var string
	 **/
	protected ?string $date_creation = null;
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id_content',
		'lang',
	];
	/**
	 * Display the content within a readable and safe form
	 *
	 * @param ?string $attribute Attribute to display (entire object if null).
	 *                           Default to null.
	 *
	 * @return ?string
	 *
	 * @throws \exception\class\content\ContentException
	 */
	public function display(?string $attribute = null) : string
	{
		try
		{
			if ($attribute === null)
			{
				try
				{
					return htmlspecialchars(
						$this->display('text')
					);
				}
				catch (\exception\class\content\ContentException $exception)
				{
					throw new \exception\class\content\ContentException(
						message:  $this->lang(
							'display',
							'error_before',
						),
						tokens:   [
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}
			try
			{
				return $this->display_($attribute);
			}
			catch (
				\exception\class\content\ContentException |
				\exception\class\core\ManagedException    |
				\exception\class\core\BaseException $exception
			)
			{
				throw new \exception\class\content\ContentException(
					message:  $this->lang(
						'display',
						'error_display',
					),
					tokens:   [
						'attribute' => $attribute,
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
		}
		catch (\exception\class\content\ContentException $exception)
		{
			throw new \exception\class\content\ContentException(
				message:  $this->lang(
					'display',
					'error',
				),
				tokens:   [
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Retrieves the text with its id and lang
	 *
	 * @return ?string
	 *
	 * @throws \exception\class\content\ContentException
	 */
	public function retrieveText() : ?string
	{
		try
		{
			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'Content',
					'retrieveText',
					'start'
				],
				$this,
			);

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'retrieveText',
					'start',
				),
			);

			try
			{
				$Manager = $this->manager();
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\content\ContentException(
					message:  $this->lang(
						'retrieveText',
						'error_manager',
					),
					tokens:   [
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			try
			{
				if ($this->exist()) // in the db
				{
					try
					{
						$this->retrieve();
					}
					catch (\exception\class\core\ManagedException $exception)
					{
						throw new \exception\class\content\ContentException(
							message:  $this->lang(
								'retrieveText',
								'error_retrieve',
							),
							tokens:   [
								'exception' => $exception->getMessage(),
							],
							previous: $exception,
						);
					}
					$GLOBALS['Logger']->log(
						[
							'class',
							'core',
							\core\LoggerTypes::DEBUG,
						],
						$this->lang(
							'retrieveText',
							'success',
						),
					);
				}
				else if (
					$Manager->existBy(
						[
							'id_content' => $this->id_content,
						],
					)
				) // manually set
				{
					$GLOBALS['Logger']->log(
						[
							'class',
							'core',
							\core\LoggerTypes::DEBUG,
						],
						$this->lang(
							'retrieveText',
							'warning',
						),
					);
					if (
						$Manager->exist(
							[
								'id_content' => $this->id_content,
								'lang' => $GLOBALS
								          ['Visitor']->getConfigurations()
								          ['lang'],
							]
						)
					)
					{
						$GLOBALS['Logger']->log(
							[
								'class',
								'core',
								\core\LoggerTypes::DEBUG,
							],
							$this->lang(
								'retrieveText',
								'success_user_lang',
							),
						);
						try
						{
							$this->hydrate(
								$Manager->get(
									[
										'id_content' => $this->id_content,
										'lang' => $GLOBALS
										          ['Visitor']->getConfigurations()
										          ['lang'],
									]
								)
							);
						}
						catch (\exception\class\core\BaseException $exception)
						{
							throw new \exception\class\content\ContentException(
								message:  $this->lang(
									'retrieveText',
									'error_hydrate',
								),
								tokens:   [
									'exception' => $exception->getMessage(),
								],
								previous: $exception,
							);
						}
					}
					else if (
						$Manager->exist(
							[
								'id_content' => $this->id_content,
								'lang' => $GLOBALS
								          ['config']
										  ['core']
										  ['locale']
										  ['default'],
							]
						)
					)
					{
						$GLOBALS['Logger']->log(
							[
								'class',
								'core',
								\core\LoggerTypes::DEBUG,
							],
							$this->lang(
								'retrieveText',
								'success_default_lang',
							),
						);
						try
						{
							$this->hydrate(
								$Manager->get(
									[
										'id_content' => $this->id_content,
										'lang' => $GLOBALS
										          ['config']
												  ['core']
												  ['lang'],
									]
								)
							);
						}
						catch (\exception\class\core\BaseException $exception)
						{
							throw new \exception\class\content\ContentException(
								message:  $this->lang(
									'retrieveText',
									'error_hydrate',
								),
								tokens:   [
									'exception' => $exception->getMessage(),
								],
								previous: $exception,
							);
						}
					}
					else
					{
						$GLOBALS['Logger']->log(
							[
								'class',
								'core',
								\core\LoggerTypes::DEBUG,
							],
							$this->lang(
								'retrieveText',
								'success_any',
							),
						);
						try
						{
							$this->retrieveBy(
								[
									'id_content' => $this->id_content,
								]
							)
							[0];
						}
						catch (\exception\class\core\ManagedException $exception)
						{
							throw new \exception\class\content\ContentException(
								message:  $this->lang(
									'retrieveText',
									'error_retrieve',
								),
								tokens:   [
									'exception' => $exception->getMessage(),
								],
								previous: $exception,
							);
						}
					}
				}
				else // missconfigured
				{
					throw new \exception\class\content\ContentException(
						message: $this->lang(
							'retrieveText',
							'failure',
						),
					);
				}
			}
			catch (\exception\class\core\ManagedException $exception)
			{
				throw new \exception\class\content\ContentException(
					message:  $this->lang(
						'retrieveText',
						'error_exist',
					),
					tokens:   [
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'Content',
					'retrieveText',
					'end'
				],
				$this,
			);

			return $this->text;
		}
		catch (
			\exception\class\content\ContentException |
			\exception\class\content\ManagerException $exception
		)
		{
			throw new \exception\class\content\ContentException(
				message:      $this->lang(
					'retrieveText',
					'error',
				),
				tokens:       [
					'exception' => $exception->getMessage(),
				],
				previous:     $exception,
			);
		}
	}
}

?>
