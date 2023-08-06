// TODO: after finishing pages api

import { SingleResultInterface } from 'src/interfaces/ApiResponseInterface';

interface PagesInterface extends SingleResultInterface {
  is_active: boolean,
}

interface TagsInterface extends SingleResultInterface {
  is_active: boolean,
}

interface ArticlesInterface extends SingleResultInterface {
  is_active: boolean,
}

interface MediaInterface extends SingleResultInterface {
  is_active: boolean,
}

interface CommentsInterface extends SingleResultInterface {
  is_active: boolean,
}


export {
  PagesInterface,
  TagsInterface,
  ArticlesInterface,
  MediaInterface,
  CommentsInterface,
}
