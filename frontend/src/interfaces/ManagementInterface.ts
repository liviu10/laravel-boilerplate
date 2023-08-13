// TODO: after finishing pages api

import { SingleResultInterface } from 'src/interfaces/ApiResponseInterface';

/**
 * Interface representing pages with various properties.
 * @property is_active - Indicates whether the page is active.
 * @interface PagesInterface
 * @extends {SingleResultInterface}
 */
interface PagesInterface extends SingleResultInterface {
  is_active: boolean
}

/**
 * Interface representing tags with various properties.
 * @property is_active - Indicates whether the tag is active.
 * @interface TagsInterface
 * @extends {SingleResultInterface}
 */
interface TagsInterface extends SingleResultInterface {
  is_active: boolean
}

/**
 * Interface representing articles with various properties.
 * @property is_active - Indicates whether the article is active.
 * @interface ArticlesInterface
 * @extends {SingleResultInterface}
 */
interface ArticlesInterface extends SingleResultInterface {
  is_active: boolean,
}

/**
 * Interface representing media with various properties.
 * @property is_active - Indicates whether the media is active.
 * @interface MediaInterface
 * @extends {SingleResultInterface}
 */
interface MediaInterface extends SingleResultInterface {
  is_active: boolean
}

/**
 * Interface representing comments with various properties.
 * @property is_active - Indicates whether the comment is active.
 * @interface CommentsInterface
 * @extends {SingleResultInterface}
 */
interface CommentsInterface extends SingleResultInterface {
  is_active: boolean
}


export {
  PagesInterface,
  TagsInterface,
  ArticlesInterface,
  MediaInterface,
  CommentsInterface,
}
