import queryString from 'query-string';

export const assetEnabled = (values, asset) => {
  if (!values || !values.length) {
    return false;
  }
  if (typeof asset === 'string') {
    return values.map((value) => value.id).includes(asset);
  }
  return values.map((value) => value.id).includes(asset.id);
};

export const search = async (query, params) => {
  let { collection } = params;
  if (!collection) {
    collection = '';
  }
  const cpTrigger = window.Craft.cpTrigger || 'admin';
  const url = queryString.stringifyUrl({
    url: `/${cpTrigger}/actions/widen/cp-asset/query`,
    query: {
      q: query,
      collection,
    },
  });
  const results = await fetch(url).then((resp) => resp.json());
  // return results.items || [];
  return results || [];
};

export const getCollections = async () => {
  const cpTrigger = window.Craft.cpTrigger || 'admin';
  const results = await fetch(
    `/${cpTrigger}/actions/widen/cp-asset/collections`,
  ).then((resp) => resp.json());
  return results || [];
};
